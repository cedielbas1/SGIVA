# Migraciones y Seeders Automatizados

Guía para ejecutar migraciones y seeders de manera segura en entornos locales, CI y producción.

## Recomendaciones generales
- Ejecutar migraciones dentro de una ventana de mantenimiento si la migración es disruptiva.
- Hacer backup de la base de datos antes de migrar en producción.
- Probar migraciones en staging antes de producción.

## Script seguro
Se incluye `scripts/migrate_and_seed.sh` que evita ejecutar migraciones en `production` a menos que se pase `FORCE=true`.

Uso local (no production):

```bash
./scripts/migrate_and_seed.sh
```

Uso en producción (con cuidado):

```bash
APP_ENV=production FORCE=true ./scripts/migrate_and_seed.sh
```

## Integración con CI/CD
- En la pipeline de despliegue, antes de ejecutar migraciones en producción:
  - Asegurar backup reciente (automatizar snapshot/dump).
  - Poner la app en modo mantenimiento: `php artisan down`.
  - Ejecutar el script con `FORCE=true` o directamente `php artisan migrate --force` si está validado.
  - Quitar modo mantenimiento: `php artisan up`.

Ejemplo de paso en GitHub Actions (`deploy` job):

```yaml
- name: Run migrations on remote
  run: ssh deploy@server "cd /var/www/sgiva && APP_ENV=production FORCE=true ./scripts/migrate_and_seed.sh"
```

## Seeders para entornos
- Evitar seeders con datos sensibles en producción. Usar seeders idempotentes y con checks para no duplicar datos.
- Para datos iniciales críticos (roles, permisos), crear seeders específicos y documentarlos.

## Rollback
- Si una migración falla y se necesita rollback, usar `php artisan migrate:rollback` o restaurar desde backup según el caso.
