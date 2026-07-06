# Despliegue y Hardening para SGIVA

Este documento reúne pasos prácticos y comandos recomendados para desplegar SGIVA en un entorno de producción seguro.

## Resumen rápido
- Establecer `APP_ENV=production` y `APP_DEBUG=false`.
- Mantener las credenciales (`.env`) fuera del repositorio y gestionarlas con un secrets manager.
- Generar `APP_KEY` en cada entorno: `php artisan key:generate`.
- Restringir permisos de archivo y configurar backups y monitoreo.

## 1) Variables de entorno
- Copiar `.env.example` a `.env` en el servidor remoto y editar valores.
- Nunca subir `.env` al repo.
- Valores críticos:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL=https://tu-dominio`
  - `APP_KEY` generado (no compartir)
  - `DB_CONNECTION=mysql` (usualmente), `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

Ejemplo de generación de `APP_KEY`:

```bash
php artisan key:generate --force
```

Usar un gestor de secretos (Vault, AWS Secrets Manager, Azure Key Vault, GitHub Secrets, etc.) para almacenar credenciales.

## 2) Permisos y seguridad de archivos
- Fijar permisos restrictivos en `.env`:

```bash
# en servidor Linux
chown www-data:www-data /path/to/sgiva/.env
chmod 640 /path/to/sgiva/.env
```

- Asegurar `storage` y `bootstrap/cache`:

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 3) Comandos de despliegue (cierto orden)
```bash
# instalar dependencias de PHP (en CI usar --no-dev)
composer install --no-dev --optimize-autoloader --no-interaction

# instalar dependencias JS y compilar assets
npm ci
npm run build

# migrar base de datos (usar --force en producción)
php artisan migrate --force

# cachear configuración/ rutas / vistas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# crear enlace storage
php artisan storage:link
```

## 4) Base de datos y backups
- Usar usuario DB con privilegios mínimos (no root). Limitar acceso por IP.
- Respaldos frecuentes: ejemplo con `mysqldump`:

```bash
mysqldump -u backup_user -p'PASSWORD' --single-transaction --quick --lock-tables=false sgiva_prod | gzip > /backups/sgiva_$(date +%F).sql.gz
```

- Automatizar con cron o solución de backups gestionada; mantener retención e integridad (verificar restauración periódica).

## 5) SSL/TLS y dominio
- Usar certificados de Let's Encrypt o proveedor gestionado.
- Forzar HTTPS: configurar servidor web (Nginx/Apache) y `APP_URL` con `https://...`.

## 6) Colas y workers
- Usar `supervisor` o systemd para run workers (queue:work) en modo daemon.

Ejemplo supervisor config (/etc/supervisor/conf.d/sgiva-worker.conf):
```
[program:sgiva-worker]
command=php /path/to/sgiva/artisan queue:work redis --sleep=3 --tries=3 --timeout=90
process_name=%(program_name)s_%(process_num)02d
numprocs=1
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/sgiva/worker.log
```

## 7) Logs, monitoreo y alertas
- Configurar `LOG_CHANNEL` para producción (stack, papertrail, sentry, etc.).
- Integrar Sentry o similar para trazas de errores.
- Añadir métricas y alertas (Prometheus + Grafana, o SaaS).

## 8) CI/CD recomendado (GitHub Actions idea)
- Pipeline mínimo:
  1. Ejecutar `composer install --no-dev` y `npm ci`.
  2. Ejecutar tests (`phpunit`).
  3. Ejecutar linter/análisis (PHPStan/Psalm, PHP-CS-Fixer opcional).
  4. Generar artefactos (build de assets) y desplegar (SSH/rsync, scp o despliegue containerizado).

## 9) Opcional: containerizar
- Dockerizar la app facilita reproducibilidad. Al desplegar, usar `docker-compose` o Kubernetes.
- No incluir secretos en la imagen; pasar variables en runtime (secrets, env vars).

## 10) Checklist de pre-despliegue
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` generado
- [ ] `.env` no en repo y con permisos correctos
- [ ] Backup completo y verificado
- [ ] SSL configurado
- [ ] Workers configurados y monitoreados
- [ ] Logs centralizados y alertas básicas

## Referencias rápidas (comandos)
```bash
# verificar sintaxis PHP (opcional)
php -l app/Http/Controllers/ActividadController.php

# ejecutar tests en CI/local
./vendor/bin/phpunit --configuration phpunit.xml
```

---
Si quieres, creo un archivo `.github/workflows/ci.yml` de ejemplo o un `Dockerfile/docker-compose.yml` base. ¿Cuál prefieres que haga a continuación?
