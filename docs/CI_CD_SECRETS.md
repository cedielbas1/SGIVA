# CI/CD Secrets and Deployment Variables

Este documento describe las variables secretas usadas por el workflow de despliegue en GitHub Actions.

## Secrets necesarios

- `DEPLOY_HOST`: IP o hostname del servidor de destino.
- `DEPLOY_PORT`: Puerto SSH (usualmente `22`).
- `DEPLOY_USER`: Usuario SSH en el servidor.
- `DEPLOY_KEY`: Clave privada SSH para autenticación sin contraseña.
- `DEPLOY_PATH`: Ruta en el servidor donde está la aplicación.

## Recomendaciones

- Añadir estos secrets en GitHub: `Settings > Secrets and variables > Actions`.
- No usar claves privadas con passphrase en el workflow a menos que se agregue manejo de passphrase seguro.
- Asegurarse de que el servidor remoto tenga la clave pública correspondiente en `~/.ssh/authorized_keys`.
- Configurar el usuario para poder ejecutar los comandos de despliegue y reiniciar servicios si es necesario.
