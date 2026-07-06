# Configuración de Dominio y SSL/TLS para SGIVA

Este documento describe la configuración de dominio, HTTPS y buenas prácticas para desplegar SGIVA de manera segura.

## 1) Configurar dominio

1. Registrar el dominio deseado con un proveedor DNS.
2. Añadir un registro A que apunte al servidor donde correrá SGIVA.
3. Si usas un CDN o proxy inverso, configura el CNAME según las instrucciones del proveedor.

## 2) Certificados SSL con Let's Encrypt

Usar Certbot para generar certificados gratuitos.

### Instalación básica

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx
```

### Obtener certificación para el dominio

```bash
sudo certbot certonly --nginx -d example.com -d www.example.com
```

### Renovación automática

Let's Encrypt expira cada 90 días; agregar a cron:

```bash
0 3 * * * /usr/bin/certbot renew --quiet
```

## 3) Configuración de Nginx

El archivo `docker/nginx/default.conf` ya incluye:

- redirección HTTP a HTTPS
- cabeceras de seguridad HSTS, X-Frame-Options, X-Content-Type-Options, CSP básico
- TLS 1.2/1.3 con ciphers seguros

### Ajustes necesarios

- Cambiar `server_name localhost;` por tu dominio real.
- Reemplazar las rutas de certificado con las rutas de certificados válidos generados por Certbot.

## 4) Recomendaciones de seguridad TLS

- Usar `ssl_protocols TLSv1.2 TLSv1.3`.
- Desactivar SSLv3/SSLv2 y TLS 1.0/1.1.
- Habilitar `HSTS` con al menos 6 meses en producción.
- Revisar la configuración con [SSL Labs](https://www.ssllabs.com/ssltest/).

## 5) Forzar HTTPS en Laravel

En `.env` de producción:

```text
APP_URL=https://example.com
TRUSTED_PROXIES=127.0.0.1,::1
SESSION_SECURE_COOKIE=true
SESSION_COOKIE=sess_sgiva
```

En `AppServiceProvider` o `.htaccess` no es necesario si nginx ya redirecciona.

## 6) Redirecciones y dominios alternativos

Si quieres forzar `www` o `sin www`, configura redirecciones en Nginx:

```nginx
server {
    listen 80;
    server_name www.example.com;
    return 301 https://example.com$request_uri;
}
```

## 7) Modo mantenimiento

Antes de cambios mayores, usar:

```bash
php artisan down
```

Y para reactivar:

```bash
php artisan up
```

## 8) Verificación

- Probar acceso HTTPS desde el navegador.
- Usar `curl -I https://example.com` para verificar cabeceras.
- Comprobar el certificado y la cadena de confianza.

---

Este documento es una guía de referencia. Ajusta según el servidor y el proveedor de infraestructura que uses.
