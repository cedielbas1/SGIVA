# SGIVA - Runbook Operativo y Guía de Mantenimiento

Documento consolidado con procedimientos operativos, troubleshooting y mejores prácticas para administrar SGIVA en producción.

## Tabla de Contenidos

1. [Inicio Rápido](#inicio-rápido)
2. [Procedimientos de Emergencia](#procedimientos-de-emergencia)
3. [Troubleshooting](#troubleshooting)
4. [Monitoreo Diario](#monitoreo-diario)
5. [Optimización y Tuning](#optimización-y-tuning)
6. [Referencias Cruzadas](#referencias-cruzadas)

---

## Inicio Rápido

### Verificar estado del sistema

```bash
curl https://sgiva.example.com/health
# Respuesta esperada: {"status":"ok", ...}
```

### Acceder al servidor

```bash
ssh deploy@your-server.com
cd /var/www/sgiva
```

### Logs en tiempo real

```bash
# Aplicación
tail -f storage/logs/laravel.log

# Workers
tail -f /var/log/sgiva/worker.log

# Nginx
tail -f /var/log/nginx/error.log
```

---

## Procedimientos de Emergencia

### 1. Base de datos inaccesible

**Síntomas**: Errores `SQLSTATE[HY000]`, página 500.

**Pasos**:

```bash
# 1. Verificar conectividad
mysql -u sgiva -p -h 127.0.0.1 -e "SELECT 1;" sgiva

# 2. Revisar estado MySQL
sudo systemctl status mysql

# 3. Si no responde, reiniciar
sudo systemctl restart mysql

# 4. Verificar espacio en disco
df -h /var/lib/mysql

# 5. Restaurar desde backup si está corrupta
cd /backups
mysql -u sgiva -p sgiva < sgiva_latest.sql.gz
```

Ver: [DB_BACKUPS.md](DB_BACKUPS.md) para procedimiento completo.

### 2. Workers caídos (colas acumuladas)

**Síntomas**: Jobs sin procesar, delay en emails.

**Pasos**:

```bash
# 1. Verificar estado de workers
sudo supervisorctl status sgiva-worker:*

# 2. Si están muertos, reiniciar
sudo supervisorctl restart sgiva-worker:*

# 3. Monitorear logs
tail -f /var/log/sgiva/worker.log

# 4. Comprobar Redis
redis-cli ping

# 5. Si Redis caído, reiniciar
sudo systemctl restart redis-server
```

Ver: [QUEUES_WORKERS_CRON.md](QUEUES_WORKERS_CRON.md) para configuración.

### 3. Certificado SSL a punto de expirar

**Síntomas**: Advertencia en navegador, error 60 en Sentry.

**Pasos**:

```bash
# 1. Renovar certificado
sudo certbot renew --dry-run

# 2. Aplicación real (automático por cron, pero puedes forzar)
sudo certbot renew --force-renewal

# 3. Verificar validez
sudo openssl x509 -in /etc/letsencrypt/live/sgiva.example.com/cert.pem -noout -dates
```

Ver: [SSL_TLS_SETUP.md](SSL_TLS_SETUP.md).

### 4. Falta de espacio en disco

**Síntomas**: App lenta, errores al escribir logs.

**Pasos**:

```bash
# 1. Diagnosticar
df -h
du -sh /var/www/sgiva/*

# 2. Limpiar logs antiguos
find /var/log/sgiva -name "*.log" -mtime +30 -delete

# 3. Vaciar cache Laravel
php artisan cache:clear
php artisan config:clear

# 4. Comprimir logs antiguos
cd /var/log/sgiva
find . -name "*.log" -mtime +7 -exec gzip {} \;

# 5. Si sigue llenando, revisar DB
mysqldump --estimate-only sgiva | tail -1
```

### 5. Sitio devuelve error 500

**Pasos**:

```bash
# 1. Revisar log de aplicación
tail -100 storage/logs/laravel.log

# 2. Revisar error de Nginx
tail -100 /var/log/nginx/error.log

# 3. Verificar permisos de archivos
sudo chown -R www-data:www-data /var/www/sgiva
sudo chmod -R 755 /var/www/sgiva
sudo chmod -R 775 /var/www/sgiva/storage /var/www/sgiva/bootstrap/cache

# 4. Regenerar cache config
php artisan config:cache
php artisan view:clear

# 5. Si persiste, modo mantenimiento temporalmente
php artisan down --message "Mantenimiento temporal"
# ... soluciona problema ...
php artisan up
```

### 6. Memoria RAM agotada

**Síntomas**: PHP crashes, workers mueren espontáneamente.

**Pasos**:

```bash
# 1. Diagnosticar
free -h
ps aux --sort=-%mem | head -20

# 2. Reducir workers
sudo supervisorctl reconfig sgiva-worker
# Editar numprocs de 4 a 2 en /etc/supervisor/conf.d/sgiva-worker.conf
# sudo supervisorctl reread && reconfig

# 3. Aumentar límite PHP
echo "memory_limit=512M" | sudo tee -a /etc/php/8.3/fpm/php.ini
sudo systemctl restart php8.3-fpm

# 4. Considerar upgrade de servidor
```

---

## Troubleshooting

### Error: "SQLSTATE[42000]: Syntax error or access violation"

**Causa**: Query SQL inválida o permisos insuficientes de BD.

**Solución**:

```bash
# Verificar usuario tiene permisos
mysql -u root -p -e "GRANT ALL PRIVILEGES ON sgiva.* TO 'sgiva'@'127.0.0.1'; FLUSH PRIVILEGES;"

# Ejecutar migraciones
php artisan migrate --force
```

### Error: "Call to undefined method..."

**Causa**: Cambios en código sin actualizar composer o cache.

**Solución**:

```bash
composer install --no-dev
php artisan cache:clear
php artisan config:clear
```

### Email no enviándose

**Pasos**:

```bash
# 1. Verificar cola de emails
php artisan tinker
>>> DB::table('jobs')->count();

# 2. Reintentar jobs fallidos
php artisan queue:retry all

# 3. Verificar configuración MAIL
env('MAIL_MAILER')
env('MAIL_HOST')
env('MAIL_PORT')

# 4. Logs de envío
tail -f storage/logs/laravel.log | grep -i mail
```

### Reportes/Gráficos no cargan

**Causa**: Query lenta, timeout en base de datos.

**Solución**:

```bash
# Incrementar timeout de query
# En .env: DB_TIMEOUT=60

# Optimizar tabla de actividades
php artisan tinker
>>> DB::statement('ANALYZE TABLE activities;');
>>> DB::statement('OPTIMIZE TABLE activities;');

# Crear índices si faltan
DB::statement('CREATE INDEX idx_activities_user ON activities(user_id, created_at);');
```

---

## Monitoreo Diario

### Checklist matutino (08:00 UTC)

```bash
#!/bin/bash
# Daily health check script

echo "=== SGIVA Daily Health Check ==="
echo "Date: $(date)"

# 1. App health
HEALTH=$(curl -s https://sgiva.example.com/health | jq .status)
echo "Health: $HEALTH"
[ "$HEALTH" == '"ok"' ] || echo "⚠️  ALERT: Health check failed"

# 2. DB
DB_CHECK=$(mysql -u sgiva -p$DB_PASSWORD -e "SELECT COUNT(*) FROM activities;" sgiva 2>&1)
echo "DB Activities: $DB_CHECK"

# 3. Workers
WORKERS=$(sudo supervisorctl status sgiva-worker:* | grep -c "RUNNING")
echo "Workers Running: $WORKERS/4"
[ "$WORKERS" -eq 4 ] || echo "⚠️  ALERT: Some workers down"

# 4. Disk
DISK=$(df /var/www/sgiva | awk 'NR==2 {print $5}' | cut -d% -f1)
echo "Disk Usage: $DISK%"
[ "$DISK" -gt 80 ] && echo "⚠️  ALERT: Disk > 80%"

# 5. Recent errors
ERRORS=$(tail -100 storage/logs/laravel.log | grep -i error | wc -l)
echo "Recent Errors: $ERRORS"

echo "=== Check Complete ==="
```

Guardar como `/usr/local/bin/sgiva-health-check.sh` y añadir a cron:

```bash
0 8 * * * /usr/local/bin/sgiva-health-check.sh >> /var/log/sgiva/health-check.log 2>&1
```

### Métricas clave a monitorear

- **Uptime**: Debe ser > 99.5%
- **Response time**: P95 < 500ms
- **Error rate**: < 0.1%
- **DB connection pool**: < 80% utilizado
- **Disk usage**: < 80%
- **Memory usage**: < 80%

---

## Optimización y Tuning

### 1. Base de datos

```bash
# Crear índices para queries lentas
mysql -u root -p sgiva < - <<EOF
CREATE INDEX idx_activities_date ON activities(created_at);
CREATE INDEX idx_lotes_cultivo ON lotes(cultivo_id);
CREATE INDEX idx_inventarios_lote ON inventarios(lote_id);
ALTER TABLE activities ADD FULLTEXT INDEX ft_observaciones (observaciones);
EOF

# Analizar query plan
EXPLAIN SELECT * FROM activities WHERE user_id = 1 AND created_at > DATE_SUB(NOW(), INTERVAL 30 DAY);

# Limpiar datos antiguos
DELETE FROM failed_jobs WHERE failed_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
```

### 2. PHP-FPM tuning

```ini
; /etc/php/8.3/fpm/pool.d/www.conf
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 1000
request_terminate_timeout = 60
```

Recargar:

```bash
sudo systemctl reload php8.3-fpm
```

### 3. Nginx tuning

```nginx
# /etc/nginx/nginx.conf
worker_processes auto;
worker_connections 2048;
keepalive_timeout 30;

# Gzip
gzip on;
gzip_types text/plain text/css application/json application/javascript;
gzip_level 4;
```

### 4. Redis optimization

```bash
# Aumentar max memory
redis-cli CONFIG SET maxmemory 2gb
redis-cli CONFIG SET maxmemory-policy allkeys-lru
redis-cli CONFIG REWRITE
```

### 5. Vite asset pipeline

```bash
# Verificar tamaños
du -sh public/build/*

# Limpiar assets obsoletos
rm -rf public/build

# Reconstruir
npm run build

# Purgar viejos manifests
find public/build -name "*.json" -mtime +30 -delete
```

---

## Referencias Cruzadas

Documentos relacionados por tema:

### Seguridad
- [SECURITY.md](../SECURITY.md) - Política de seguridad
- [SECURITY_CHECKLIST.md](../SECURITY_CHECKLIST.md) - Checklist inicial
- [SSL_TLS_SETUP.md](SSL_TLS_SETUP.md) - Certificados y HTTPS

### Deployment
- [DEPLOYMENT.md](DEPLOYMENT.md) - Configuración inicial del servidor
- [CI_CD_SECRETS.md](CI_CD_SECRETS.md) - Secrets de GitHub Actions
- [MIGRATIONS_SEEDERS.md](MIGRATIONS_SEEDERS.md) - Migraciones seguras

### Data
- [DB_BACKUPS.md](DB_BACKUPS.md) - Backups y rotación
- [RECOVERY_PLAN.md](RECOVERY_PLAN.md) - Plan de disaster recovery

### Operations
- [QUEUES_WORKERS_CRON.md](QUEUES_WORKERS_CRON.md) - Colas y tareas programadas
- [MONITORING_LOGGING_ALERTS.md](MONITORING_LOGGING_ALERTS.md) - Logs y alertas
- [ASSET_OPTIMIZATION.md](ASSET_OPTIMIZATION.md) - Performance de assets

### Development
- [../README.md](../README.md) - Información general del proyecto

---

## Contactos y Escaladas

En caso de emergencia:

- **DevOps Lead**: devops@example.com
- **Database Admin**: dba@example.com
- **Security Officer**: security@example.com
- **CTO On-call**: +1-XXX-XXX-XXXX

Severity levels:
- **P1 (Critical)**: App down, data loss risk → Escalate inmediatamente
- **P2 (High)**: Degraded performance → 1 hora para mitigar
- **P3 (Medium)**: Warnings, non-critical features down → Best effort
- **P4 (Low)**: Documentation updates, refactoring → Next sprint

---

## Log del runbook

| Fecha | Evento | Resolución | Tiempo |
|-------|--------|-----------|---------|
| 2026-07-06 | Inicial | Creación de runbook | - |

---

**Última actualización**: 2026-07-06  
**Próxima revisión**: 2026-09-06  
**Responsable**: DevOps Team
