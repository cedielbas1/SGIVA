# 🔐 SGIVA - Documento de Seguridad y Arquitectura

Última actualización: 18 de mayo de 2026

## 📋 Cambios de Seguridad Implementados

### 1. Control de Roles y Autorización

#### Antes (Inseguro ❌)
```php
// Cualquier usuario registrado era creado como 'admin'
protected function create(array $data)
{
    return User::create([
        'role' => 'admin', // CRÍTICO: TODOS eran admin!
    ]);
}

// Las políticas permitían a CUALQUIERA crear y editar recursos
public function create(User $user): bool
{
    return true; // Todos los autenticados pueden crear
}
```

#### Después (Seguro ✅)
```php
// Nuevos usuarios registrados como 'user'
protected function create(array $data)
{
    return User::create([
        'role' => 'user', // Rol por defecto seguro
    ]);
}

// Políticas restrictivas por rol
public function create(User $user): bool
{
    return $user->isAdmin(); // Solo admin y super_admin
}
```

### 2. Protección de Rutas con Middleware de Roles

#### Nuevo archivo: `routes/web.php`

**Rutas públicas autenticadas** (lectura):
- `GET /cultivos`, `GET /cultivos/{id}`
- `GET /lotes`, `GET /lotes/{id}`
- `GET /inventarios`, `GET /inventarios/{id}`
- `GET /actividades`, `GET /actividades/{id}`
- `GET /insumos`, `GET /insumos/{id}`
- `GET /ventas`, `GET /ventas/{id}`

**Rutas protegidas (admin only)**:
- `POST/PUT/DELETE /cultivos/*`
- `POST/PUT/DELETE /lotes/*`
- `POST/PUT/DELETE /inventarios/*`
- `POST/PUT/DELETE /insumos/*`
- `POST/PUT/DELETE /ventas/*`

**Rutas especiales (user + admin)**:
- `POST /actividades` (usuario registra la suya)
- `PUT/DELETE /actividades/{id}` (user creador o admin)

```php
// Middleware aplicado en rutas críticas
Route::middleware(['auth', 'check_role:admin'])->group(function () {
    Route::post('/cultivos', [CultivoController::class, 'store']);
    // ...
});
```

### 3. Validación Segura de Datos (Mass Assignment)

#### Antes (Vulnerable ❌)
```php
public function store(Request $request)
{
    $request->validate([...]);
    
    Cultivo::create($request->all()); // Podría aceptar campos no permitidos
}
```

#### Después (Seguro ✅)
```php
public function store(Request $request)
{
    $request->validate([...]);
    
    Cultivo::create($request->validated()); // Solo campos validados
}
```

**Afectados**:
- CultivoController
- LoteController
- InventarioController
- InsumoController
- VentaController
- ActividadController

### 4. Deshabilitación del Registro Público

El archivo `routes/web.php` **NO incluye** `Auth::routes()` que habilita registro público.

**Rutas de autenticación activas** (solo login/logout):
- `POST /login` - Iniciar sesión
- `GET /login` - Formulario de login
- `POST /logout` - Cerrar sesión
- `POST /password/email` - Recuperación de contraseña
- `GET /password/reset` - Formulario de recuperación

**Registro público**: ❌ Deshabilitado

**Para crear usuarios**: Los usuarios deben ser creados por:
1. Seeder en desarrollo (`php artisan migrate:fresh --seed`)
2. Controlador admin (crear en el futuro)
3. Command artisan (crear en el futuro)

---

## 🔑 Roles y Permisos

### Super Admin (`super_admin`)
- ✅ Ver todos los recursos
- ✅ Crear, editar, eliminar cultivos, lotes, inventarios, insumos, ventas
- ✅ Ver todas las actividades
- ✅ Restaurar y forzar eliminar recursos
- ✅ Acceso total al sistema

### Admin (`admin`)
- ✅ Ver todos los recursos
- ✅ Crear, editar, eliminar cultivos, lotes, inventarios, insumos, ventas
- ✅ Ver todas las actividades
- ✅ Editar/eliminar cualquier actividad
- ❌ NO puede restaurar o forzar eliminar

### User (`user`)
- ✅ Ver todos los recursos (lectura)
- ✅ Crear actividades propias
- ✅ Editar/eliminar sus propias actividades
- ❌ NO puede crear/editar recursos maestros
- ❌ NO puede eliminar recursos

---

## 📦 Usuarios de Prueba

Al ejecutar `php artisan migrate:fresh --seed`:

```bash
# Super Admin
Email: superadmin@sgiva.local
Password: password
Role: super_admin

# Admin
Email: admin@sgiva.local
Password: password
Role: admin

# Usuario General
Email: usuario@sgiva.local
Password: password
Role: user
```

---

## 🛡️ Mejores Prácticas a Seguir

### 1. Nunca usar `request->all()`
```php
// ❌ Malo
Model::create($request->all());

// ✅ Bien
Model::create($request->validated());
```

### 2. Usar `authorize()` en controladores
```php
public function update(Request $request, Cultivo $cultivo)
{
    $this->authorize('update', $cultivo); // Verifica política
    
    $cultivo->update($request->validated());
}
```

### 3. Proteger rutas con middleware
```php
// ✅ Mejor
Route::middleware(['auth', 'check_role:admin'])->group(function () {
    Route::post('/cultivos', [CultivoController::class, 'store']);
});

// ❌ Menos confiable
Route::post('/cultivos', [CultivoController::class, 'store'])->middleware('auth');
```

### 4. Validar con reglas estrictas
```php
// ✅ Bien
$request->validate([
    'nombre' => 'required|unique:cultivos|max:255',
    'estado' => 'required|boolean',
]);

// ❌ Genérico
$request->validate([
    'nombre' => 'required',
]);
```

### 5. Documentar políticas en comentarios
```php
public function update(User $user, Cultivo $cultivo): bool
{
    // Solo admins pueden actualizar cultivos
    return $user->isAdmin();
}
```

---

## 🔄 Flujo de Autorización

```
Request → Middleware 'auth' → Middleware 'check_role' → Controller 
        → authorize() (Policy) → Lógica de negocio
```

**Ejemplo: Crear un cultivo como usuario regular**
1. `POST /cultivos` con datos
2. ❌ Middleware `check_role:admin` → Error 403
3. No llega al controller

**Ejemplo: Crear actividad como usuario**
1. `POST /actividades` con datos
2. ✅ Middleware `auth` → Pasa
3. ✅ Controller: `authorize('create', Actividad::class)`
4. ✅ ActividadPolicy: Permite a cualquier autenticado
5. ✅ `user_id = auth()->id()` → Se registra como suya
6. ✅ Guardada

---

## 🚀 Próximas Mejoras Recomendadas

### Corto Plazo
- [ ] Crear formulario/comando para crear usuarios como admin
- [ ] Implementar rates limiting en login
- [ ] Añadir logging de auditoría (quién hizo qué, cuándo)
- [ ] Tests unitarios de políticas

### Mediano Plazo
- [ ] Roles y permisos granulares (spatie/laravel-permission)
- [ ] Soft deletes en modelos principales
- [ ] Encriptación de datos sensibles
- [ ] 2FA (autenticación de dos factores)

### Largo Plazo
- [ ] API con OAuth 2.0
- [ ] Webhooks de eventos
- [ ] Auditoría completa con trail
- [ ] Alertas de seguridad

---

## 🧪 Verificar Seguridad

### Test de políticas
```bash
php artisan test --filter=CultivoPolicy
php artisan test --filter=PolicyTest
```

### Test de middleware
```bash
php artisan test --filter=CheckRoleTest
```

### Verificar rutas
```bash
php artisan route:list
```

---

## 📝 Notas Importantes

1. **Never trust user input**: Siempre validar y sanitizar
2. **Default deny**: Las políticas por defecto deben negar, no permitir
3. **Middleware orden**: `auth` antes que `check_role`
4. **Logs**: Revisar `storage/logs/laravel.log` para errores
5. **Contraseñas**: Las de prueba (`password`) solo para desarrollo
6. **Variables de entorno**: Cambiar `APP_DEBUG=false` en producción

---

## 📞 Contacto / Reportar Vulnerabilidades

Si encuentras una vulnerabilidad de seguridad:
1. NO la reportes en issues públicos
2. Contacta directamente al equipo de desarrollo
3. Describe el paso a paso para reproducirla

---

**Documento de seguridad vigente para SGIVA**  
*Generado: 18 de mayo de 2026*
