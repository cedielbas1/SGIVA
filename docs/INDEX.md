# SGIVA - Documentación Completa

Índice de toda la documentación disponible para SGIVA. Selecciona un tema para comenzar.

## 🚀 Inicio Rápido

- **[RUNBOOK.md](RUNBOOK.md)** - Guía operativa completa con procedures de emergencia (⭐ EMPIEZA AQUÍ)
- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Cómo deployar SGIVA en un servidor

## 🔐 Seguridad

- **[../SECURITY.md](../SECURITY.md)** - Política de seguridad y reporte de vulnerabilidades
- **[SSL_TLS_SETUP.md](SSL_TLS_SETUP.md)** - Configurar HTTPS con Let's Encrypt

## 💾 Datos y Backups

- **[DB_BACKUPS.md](DB_BACKUPS.md)** - Estrategia de backups con mysqldump, cron, rotación y S3
- **[RECOVERY_PLAN.md](RECOVERY_PLAN.md)** - Plan de disaster recovery (RTO/RPO, playbooks, rollback)

## 🔄 Deployments y Migración

- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Configuración inicial del servidor (usuarios, permisos, servicios)
- **[MIGRATIONS_SEEDERS.md](MIGRATIONS_SEEDERS.md)** - Ejecución segura de migraciones en producción
- **[CI_CD_SECRETS.md](CI_CD_SECRETS.md)** - Secrets de GitHub Actions para deploy automatizado

## ⚙️ Infraestructura y DevOps

- **[QUEUES_WORKERS_CRON.md](QUEUES_WORKERS_CRON.md)** - Colas asincrónicas, workers y tareas programadas (cron)
- **[ASSET_OPTIMIZATION.md](ASSET_OPTIMIZATION.md)** - Pipeline de Vite, optimización de assets frontend

## 📊 Monitoreo y Observabilidad

- **[MONITORING_LOGGING_ALERTS.md](MONITORING_LOGGING_ALERTS.md)** - Logging centralizado, Sentry, health checks, alertas

## 📚 Estructura de Documentación

```
docs/
├── INDEX.md (este archivo)
├── RUNBOOK.md (operativo - emergencias)
├── DEPLOYMENT.md (server setup)
├── DB_BACKUPS.md (backup strategy)
├── RECOVERY_PLAN.md (disaster recovery)
├── MIGRATIONS_SEEDERS.md (migrations safety)
├── QUEUES_WORKERS_CRON.md (async jobs)
├── ASSET_OPTIMIZATION.md (frontend performance)
├── MONITORING_LOGGING_ALERTS.md (observability)
├── SSL_TLS_SETUP.md (HTTPS & certificates)
└── CI_CD_SECRETS.md (GitHub Actions)
```

## 🎯 Por Caso de Uso

### "Mi app está caída"
→ Ver [RUNBOOK.md](RUNBOOK.md) - Procedimientos de Emergencia

### "Necesito hacer backup de BD"
→ Ver [DB_BACKUPS.md](DB_BACKUPS.md)

### "Quiero recuperarme de un desastre"
→ Ver [RECOVERY_PLAN.md](RECOVERY_PLAN.md)

### "Deploying la primera vez"
→ Ver [DEPLOYMENT.md](DEPLOYMENT.md)

### "Los workers se murieron"
→ Ver [RUNBOOK.md](RUNBOOK.md#2-workers-caídos-colas-acumuladas)

### "Necesito alertas y logs"
→ Ver [MONITORING_LOGGING_ALERTS.md](MONITORING_LOGGING_ALERTS.md)

### "Mi certificado SSL expira"
→ Ver [SSL_TLS_SETUP.md](SSL_TLS_SETUP.md) o [RUNBOOK.md](RUNBOOK.md#3-certificado-ssl-a-punto-de-expirar)

## ✅ Checklist de Producción

Antes de lanzar a producción, completar:

- [ ] [DEPLOYMENT.md](DEPLOYMENT.md) - Servidor configurado
- [ ] [SSL_TLS_SETUP.md](SSL_TLS_SETUP.md) - HTTPS activo
- [ ] [DB_BACKUPS.md](DB_BACKUPS.md) - Backups programados
- [ ] [RECOVERY_PLAN.md](RECOVERY_PLAN.md) - Plan testeado
- [ ] [MIGRATIONS_SEEDERS.md](MIGRATIONS_SEEDERS.md) - Migraciones automáticas
- [ ] [CI_CD_SECRETS.md](CI_CD_SECRETS.md) - GitHub Actions funcional
- [ ] [QUEUES_WORKERS_CRON.md](QUEUES_WORKERS_CRON.md) - Workers y cron configurados
- [ ] [MONITORING_LOGGING_ALERTS.md](MONITORING_LOGGING_ALERTS.md) - Alertas activas
- [ ] [ASSET_OPTIMIZATION.md](ASSET_OPTIMIZATION.md) - Assets optimizados
- [ ] [RUNBOOK.md](RUNBOOK.md) - Team familiarizado con emergencias

## 🚨 Escalación

Para emergencias de P1 (aplicación caída):

1. Leer [RUNBOOK.md](RUNBOOK.md) - Procedimientos de Emergencia
2. Contactar DevOps Lead
3. Ejecutar procedimiento correspondiente
4. Documentar en incident log

---

**Última actualización**: 2026-07-06  
**Responsable**: Engineering Team  
**Próxima revisión**: Cuando se añada nueva documentación
