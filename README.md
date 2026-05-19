# SGIVA - Sistema de Gestión Integral de Ventas Agrícolas

Sistema de gestión agrícola desarrollado con Laravel 13.7 para administrar cultivos, lotes, inventarios, actividades, insumos y ventas.

## 🚀 Características

- ✅ **Gestión de Cultivos**: Crear, editar y eliminar tipos de cultivos (Café, Aguacate, Cacao, etc.)
- ✅ **Gestión de Lotes**: Administrar parcelas de terreno con códigos únicos
- ✅ **Control de Inventario**: Registrar y rastrear cantidad de plantas por lote y fila
- ✅ **Actividades Agrícolas**: Registrar operaciones (riego, fumigación, siembra, cosecha, etc.)
- ✅ **Gestión de Insumos**: Control de semillas, fertilizantes, pesticidas y otros materiales
- ✅ **Registro de Ventas**: Registrar ventas con cálculo automático de totales
- ✅ **Sistema de Roles**: Super Admin, Admin y Usuario con permisos específicos
- ✅ **Autorización basada en Políticas**: Políticas Laravel para control granular de acceso

## 🛠️ Stack Tecnológico

- **Framework**: Laravel 13.7
- **PHP**: 8.3+
- **Base de Datos**: SQLite (por defecto) o MySQL/PostgreSQL
- **Frontend**: Blade Templates con Bootstrap 5.3 + Tailwind CSS 4.0
- **Bundler**: Vite 8.0.0
- **Testing**: PHPUnit 12.5.12
- **Code Standards**: Laravel Pint 1.27

## 📦 Requisitos Previos

- PHP 8.3 o superior
- Composer
- Node.js 18+ (para Vite)
- SQLite o MySQL

## 🔧 Instalación

### 1. Clonar o descargar el proyecto
```bash
cd c:\laragon\www\SGIVA
```

### 2. Instalar dependencias PHP
```bash
composer install
```

### 3. Instalar dependencias Node
```bash
npm install
```

### 4. Configurar variables de entorno
```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar APP_KEY
php artisan key:generate
```

### 5. Crear base de datos SQLite (si no existe)
```bash
# La base de datos se crea automáticamente en database/database.sqlite
# O ejecutar migraciones (ver paso 6)
```

### 6. Ejecutar migraciones
```bash
php artisan migrate
```

### 7. (Opcional) Ejecutar seeders para datos de prueba
```bash
php artisan migrate:fresh --seed
```

### 8. Compilar assets
```bash
npm run dev
# O para producción:
npm run build
```

### 9. Iniciar servidor de desarrollo
```bash
php artisan serve
```

Acceder a: http://localhost:8000

## 🔐 Autenticación y Roles

### Sistema de Roles Implementado

**Super Admin**
- Acceso completo a todas las funciones
- Gestión de usuarios y asignación de roles
- Visualización de reportes completos

**Admin**
- Gestión de cultivos, lotes, inventarios
- Creación de actividades e insumos
- Procesamiento de ventas
- Sin acceso a administración de usuarios

**Usuario**
- Visualización de cultivos y lotes
- Registro de actividades propias
- Visualización de reportes
- Acceso limitado a edición

### Crear Usuario de Prueba

```bash
php artisan tinker
```

```php
// Crear Super Admin
User::create([
    'name' => 'Super Admin',
    'email' => 'admin@sgiva.local',
    'password' => bcrypt('password'),
    'role' => 'super_admin'
]);

// Crear Admin
User::create([
    'name' => 'Administrador',
    'email' => 'gerente@sgiva.local',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);

// Crear Usuario Normal
User::create([
    'name' => 'Usuario',
    'email' => 'usuario@sgiva.local',
    'password' => bcrypt('password'),
    'role' => 'usuario'
]);
```

## 📋 Estructura de Rutas

### Públicas
- `GET /` - Página de bienvenida
- `POST /register` - Registro de nuevos usuarios
- `POST /login` - Inicio de sesión

### Autenticadas (requieren login)
- `GET /dashboard` - Panel principal
- `GET /cultivos` - Listado de cultivos
- `POST /cultivos` - Crear cultivo
- `GET /cultivos/{id}` - Ver cultivo
- `PUT /cultivos/{id}` - Editar cultivo
- `DELETE /cultivos/{id}` - Eliminar cultivo

- `GET /lotes` - Listado de lotes
- `POST /lotes` - Crear lote
- `GET /lotes/{id}` - Ver lote
- `PUT /lotes/{id}` - Editar lote
- `DELETE /lotes/{id}` - Eliminar lote

- `GET /inventarios` - Listado de inventarios
- `GET /actividades` - Listado de actividades
- `GET /insumos` - Listado de insumos
- `GET /ventas` - Listado de ventas

## 📊 Modelos y Relaciones

```
User
├─ hasMany(Actividad)
└─ timestamps

Cultivo
├─ hasMany(Lote)
├─ hasMany(Inventario)
├─ hasMany(Insumo)
├─ hasMany(Venta)
└─ timestamps

Lote
├─ belongsTo(Cultivo)
├─ hasMany(Inventario)
├─ hasMany(Actividad)
├─ hasMany(Venta)
└─ timestamps

Inventario
├─ belongsTo(Lote)
└─ timestamps

Actividad
├─ belongsTo(User)
├─ belongsTo(Lote)
└─ timestamps

Insumo
├─ belongsTo(Cultivo, nullable)
└─ timestamps

Venta
├─ belongsTo(Cultivo)
├─ belongsTo(Lote)
└─ timestamps
```

## 🚀 Primeros Pasos

1. **Crear Cultivo**: Navega a Cultivos → Nueva Cultivo
2. **Crear Lote**: Navega a Lotes → Nuevo Lote (asociar a cultivo)
3. **Agregar Inventario**: Navega a Inventarios → Nuevo Inventario
4. **Registrar Actividad**: Navega a Actividades → Nueva Actividad
5. **Ingresar Insumos**: Navega a Insumos → Nuevo Insumo
6. **Registrar Venta**: Navega a Ventas → Nueva Venta

## 🧪 Testing

Ejecutar tests unitarios:
```bash
php artisan test
```

Ejecutar con cobertura:
```bash
php artisan test --coverage
```

## 📝 Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear

# Limpiar config
php artisan config:clear

# Regenerar claves de autoload
composer dump-autoload

# Revisar código (Laravel Pint)
./vendor/bin/pint

# Resetear base de datos
php artisan migrate:fresh

# Ver rutas registradas
php artisan route:list

# Crear modelo con migración y controlador
php artisan make:model NombreModelo -mcr
```

## 🔄 Configuración de Base de Datos

### SQLite (Por defecto)
La base de datos se almacena en `database/database.sqlite`

### MySQL
1. Editar `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sgiva
DB_USERNAME=root
DB_PASSWORD=
```

2. Crear base de datos:
```bash
mysql -u root -e "CREATE DATABASE sgiva;"
```

3. Ejecutar migraciones:
```bash
php artisan migrate
```

## 📧 Contacto y Soporte

Para reportar bugs o sugerencias, contactar al equipo de desarrollo.

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT.

---

**Última actualización**: 2026-01-09
**Versión**: 1.0.0


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
