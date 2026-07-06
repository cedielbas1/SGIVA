# Monitoreo, Logging y Alertas

Guía para implementar logging centralizado, error tracking y alertas en SGIVA.

## 1) Configuración de Logging

### 1.1 Drivers de logging

En `config/logging.php` puedes usar varios drivers:

- **stack**: múltiples canales (archivo + Sentry).
- **single**: archivo único.
- **daily**: archivo diario con rotación.
- **syslog**: Sistema de log del SO.
- **papertrail**: Servicio cloud.
- **slack**: Enviar logs a Slack.

### 1.2 Configuración en .env (producción)

```env
LOG_CHANNEL=stack
LOG_LEVEL=error
LOG_SLACK_WEBHOOK_URL=https://hooks.slack.com/services/YOUR/WEBHOOK/URL
```

### 1.3 Stack logging recomendado

En `config/logging.php`:

```php
'stack' => [
    'driver' => 'stack',
    'channels' => ['daily', 'sentry'],
    'ignore_exceptions' => false,
],

'daily' => [
    'driver' => 'daily',
    'path' => storage_path('logs/laravel.log'),
    'level' => env('LOG_LEVEL', 'error'),
    'days' => 30,
],

'sentry' => [
    'driver' => 'sentry',
    'level' => 'error',
],
```

## 2) Sentry para Error Tracking

### 2.1 Instalación

```bash
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

### 2.2 Configuración

En `.env`:

```env
SENTRY_LARAVEL_DSN=https://YOUR_KEY@YOUR_DOMAIN.ingest.sentry.io/PROJECT_ID
SENTRY_ENVIRONMENT=production
SENTRY_TRACES_SAMPLE_RATE=0.1  # 10% de transactions
```

### 2.3 Logging con Sentry

```php
// En controlador
try {
    // código
} catch (Exception $e) {
    \Sentry\captureException($e);
    return response()->json(['error' => 'Error interno'], 500);
}
```

Sentry agrupa errores similares, proporciona stack traces y context.

## 3) Health Checks

### 3.1 Endpoint de health

Crear `app/Http/Controllers/HealthController.php`:

```php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function check()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 503);
        }
    }
}
```

Ruta en `routes/web.php`:

```php
Route::get('/health', [HealthController::class, 'check']);
```

### 3.2 Monitoreo desde afuera

Herramientas como Uptime Robot, Pingdom u otras pueden hacer ping a `/health` cada minuto.

## 4) Alertas por Email

### 4.1 Notificaciones de errores críticos

Crear `app/Notifications/AlertCriticalError.php`:

```php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AlertCriticalError extends Notification
{
    public function __construct(public $error)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('ALERTA: Error crítico en SGIVA')
            ->line($this->error['message'])
            ->line('Stack: ' . $this->error['stack'])
            ->action('Ver en Sentry', env('SENTRY_URL'));
    }
}
```

Desde Sentry, crear una acción para enviar email en eventos críticos.

## 5) Alertas a Slack

### 5.1 Configuración en Laravel

```env
LOG_SLACK_WEBHOOK_URL=https://hooks.slack.com/services/YOUR/WEBHOOK/URL
LOG_SLACK_CHANNEL=#alerts
LOG_SLACK_USERNAME=SGIVABot
```

### 5.2 Registrar mensajes

```php
\Illuminate\Support\Facades\Log::channel('slack')->alert('Erro crítico: ' . $exception->getMessage());
```

## 6) Monitoreo de recursos del servidor

### 6.1 Supervisar con Prometheus (opcional)

Instalar paquete Laravel Prometheus:

```bash
composer require promphp/prometheus_client
```

Crear endpoint `/metrics` que exponga métricas.

### 6.2 Grafana para visualización

Conectar Prometheus a Grafana para dashboards de CPU, RAM, requests/s.

## 7) Recomendaciones de alertas

- **Error Rate > 1%**: Alerta crítica.
- **Response time > 2s**: Alerta media.
- **Disk usage > 80%**: Alerta media.
- **Worker dead**: Alerta crítica.
- **DB connection failed**: Alerta crítica.

## 8) Logeo de acciones importantes

Añadir a modelo (auditing):

```php
// app/Models/Activity.php
use Illuminate\Support\Facades\Log;

protected static function created(Activity $model)
{
    Log::info('Activity created', [
        'activity_id' => $model->id,
        'user_id' => auth()->id(),
        'ip' => request()->ip(),
    ]);
}
```

## 9) Rotación de logs

En `config/logging.php`:

```php
'daily' => [
    'driver' => 'daily',
    'path' => storage_path('logs/laravel.log'),
    'level' => 'error',
    'days' => 30,  // Retener 30 días
],
```

## 10) Checklist de monitoreo

- [ ] Configurar Sentry DSN
- [ ] Habilitar logging stack
- [ ] Health check endpoint activo
- [ ] Alertas Slack o Email configuradas
- [ ] Prometheus/Grafana en producción (opcional)
- [ ] Logs rotan automáticamente
- [ ] Revisar logs regularmente

---

Para más info: [Laravel Logging](https://laravel.com/docs/11.x/logging) y [Sentry Docs](https://docs.sentry.io/platforms/php/guides/laravel/).
