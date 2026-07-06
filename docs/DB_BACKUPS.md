# Acceso y Respaldos de Base de Datos (MySQL)

Guía rápida para crear usuarios con mínimos privilegios, realizar backups automáticos, verificar y restaurar. Está orientada a MySQL (Laragon / producción).

## 1) Usuario de backup (privilegios mínimos)
Usar un usuario dedicado para backups/restore con los privilegios necesarios:

```sql
CREATE USER 'backup_user'@'127.0.0.1' IDENTIFIED BY 'REPLACE_WITH_STRONG_PASSWORD';
GRANT SELECT, LOCK TABLES, SHOW VIEW, EVENT, TRIGGER ON `sgiva`.* TO 'backup_user'@'127.0.0.1';
FLUSH PRIVILEGES;
```

Nota: si usas `mysqldump --single-transaction` no necesitas `LOCK TABLES` para InnoDB, pero algunas operaciones y engines lo requieren.

## 2) Script de backup (ejemplo)
Guarda este script como `/usr/local/bin/sgiva_backup.sh` y dale permisos ejecutables.

```bash
#!/bin/bash
set -euo pipefail

BACKUP_DIR=/var/backups/sgiva
mkdir -p "$BACKUP_DIR"
NOW=$(date +"%F_%H%M")
FILE="$BACKUP_DIR/sgiva_$NOW.sql.gz"

DB_HOST=127.0.0.1
DB_USER=backup_user
DB_PASS='REPLACE_WITH_STRONG_PASSWORD'
DB_NAME=sgiva

mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" \
  --single-transaction --quick --skip-lock-tables "$DB_NAME" | gzip > "$FILE"

# optional: remove backups older than 30 days
find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +30 -delete

echo "Backup completed: $FILE"
```

## 3) Cron job (ejemplo)
Ejecutar el script diariamente a las 02:00 AM:

```cron
0 2 * * * /usr/local/bin/sgiva_backup.sh >> /var/log/sgiva/backup.log 2>&1
```

## 4) Copia remota / offsite y encriptación
- Copia los backups a un almacenamiento fuera del servidor (S3, SCP a otro host, etc.).
- Para mayor seguridad, cifra los archivos antes de enviarlos (gpg o sops).

Ejemplo rápido con `aws cli` (S3):

```bash
aws s3 cp "$FILE" s3://my-bucket/sgiva/ --storage-class STANDARD_IA
```

## 5) Verificación del backup (restauración de prueba)
Probar la restauración en un entorno aislado es crítico:

```bash
gunzip < sgiva_2026-07-06_0200.sql.gz | mysql -u testuser -p test_sgiva
```

O crear una base temporal y restaurar:

```bash
mysql -u root -p -e "CREATE DATABASE sgiva_test;"
gunzip < sgiva_2026-07-06_0200.sql.gz | mysql -u root -p sgiva_test
```

## 6) Procedimiento de restauración (producción)
1. Poner la aplicación en modo mantenimiento: `php artisan down`
2. Restaurar el dump:
   ```bash
   gunzip < latest_dump.sql.gz | mysql -u root -p sgiva
   ```
3. Ejecutar migraciones si es necesario `php artisan migrate --force` (preferible revisar primero).
4. Volver a traer la app: `php artisan up`

## 7) Recomendaciones adicionales
- Automatizar verificación de backups (script que restaure en DB temporal y ejecute consultas de sanity).
- Mantener retención razonable (ej.: 30 días) y backups semanales mensuales separados.
- Monitorizar fallos de backup y enviar alertas (email, Slack, PagerDuty).
- Considerar snapshots del disco en proveedores cloud para recuperación rápida.

## 8) Registro de cambios
Anota horarios, tamaño, y ubicación de cada backup en un log para auditoría.
