# Plan de Recuperación y Playbook de Desastres (DR)

Este documento describe las acciones y procedimientos para restaurar SGIVA ante un incidente mayor (pérdida de datos, fallo de servidor, corrupción de DB, etc.). Incluye objetivos, pasos de restauración y pruebas periódicas.

## Objetivos
- RTO (Recovery Time Objective): objetivo de tiempo para recuperación — sugerido: 4 horas para incidentes críticos.
- RPO (Recovery Point Objective): pérdida máxima de datos aceptable — sugerido: 1 hora (depende de la frecuencia de backups y binlogs).

## Preparación (antes del incidente)
- Tener backups automatizados y monitorizados (ver `docs/DB_BACKUPS.md`).
- Mantener snapshots del servidor/volumen si el proveedor lo permite.
- Documentar accesos de emergencia (SSH, panel proveedor, claves rotadas) y contactos responsables.

## Roles y contactos
- Responsable técnico: Nombre / correo / teléfono
- Responsable de base de datos: Nombre / correo / teléfono
- Equipo de soporte: canal Slack o PagerDuty

## Playbook: fallo de base de datos (recuperación desde dump)
1. Evaluar alcance y decidir restauración completa o parcial.
2. Poner la aplicación en mantenimiento: `php artisan down`.
3. Tomar snapshot del servidor/estado actual para análisis forense (si aplica).
4. Restaurar la base de datos desde el backup más reciente verificable:

```bash
# parar servicios que puedan escribir en la DB si aplica
gunzip < /backups/sgiva_latest.sql.gz | mysql -u root -p sgiva
```

5. Ejecutar migraciones necesarias con precaución: `php artisan migrate --force` (revisar antes).
6. Vaciar caches y reconstruir: `php artisan config:cache && php artisan route:cache && php artisan view:clear`.
7. Quitar modo mantenimiento y verificar la aplicación: `php artisan up`.
8. Ejecutar pruebas básicas de smoke (login, listado de entidades, operaciones críticas).

## Playbook: servidor caído (recreación en nuevo host)
1. Provisionar nuevo host con especificaciones mínimas.
2. Restaurar volúmenes y backups de base de datos según `docs/DB_BACKUPS.md`.
3. Desplegar la aplicación (usar scripts de despliegue o Docker).
4. Restaurar certificados/SSL y DNS si es necesario.
5. Realizar pruebas de aceptación y monitorización activa.

## Procedimiento de rollback (si despliegue falla)
1. Si el despliegue introduce errores, revertir a la versión anterior en el control de versiones.
2. Restaurar base de datos desde snapshot/dump previo al despliegue si hubo cambios incompatibles.
3. Comunicar a usuarios y registrar el incidente.

## Pruebas y simulacros
- Programar pruebas de recuperación trimestrales: restauración en entorno aislado y validación funcional.
- Verificar integridad de backups y tiempos de restauración (recordar medir RTO/RPO reales).

## Logs y forense
- Conservar logs de sistema y aplicación durante al menos 90 días.
- Cuando sea necesario, exportar registros y correlacionar eventos para encontrar causa raíz.

## Post-mortem y mejoras
- Después de cada incidente realizar post-mortem documentado: causas, impact, acciones correctivas y cronograma de implementación.

## Checklist rápido de recuperación
- [ ] Backup disponible y verificado
- [ ] Accesos de emergencia listos
- [ ] Snapshot creado antes de cualquier operación destructiva
- [ ] Restauración verificada en entorno de staging

---
Guardar este documento junto con `docs/DB_BACKUPS.md` y `docs/DEPLOYMENT.md`. ¿Quieres que añada scripts automáticos de verificación (CI) para validación de backups? 
