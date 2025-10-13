# laravel-webhooks

> “Your Laravel app, now fluent in webhooks.”

**laravel-webhooks** is a lightweight Laravel package that lets clients register for webhooks via API, including callback URLs and bearer tokens.  
Webhooks are stored as models (with UUIDs) and can be triggered by other parts of your Laravel application with automatic retry logic and exponential backoff.

## 📦 Installation

Install the package via Composer:

```bash
composer require mcgo/laravel-webhooks
```

Run the migrations:

```bash
php artisan migrate
```

---

## 🚀 Usage

### Registering a Webhook Client

A client can register itself via API, just add the authentication and route yourself and point it to the shipped controller
``` McGo\Webhooks\Controllers\PostWebhookRegistration ```

```http
POST /api/webhooks/register
Content-Type: application/json

{
  "url": "https://client.example.com/webhook",
  "auth_header": "Authorization"
  "auth_token": "Bearer 123"
}
```

Response:

```json
{
  "uuid": "a1b2c3d4-…",
  "url": "https://client.example.com/webhook"
}
```

### Dispatching a Webhook

Simply call the action ``` McGo\Webhooks\Actions\CallWebhookRegistration ``` or make use of the job that will retry sending
when the first attempts did not work.

```php
use McGo\Webhooks\Actions\CallWebhookRegistration;
use McGo\Webhooks\Models\WebhookRegistration;
use McGo\Webhooks\Jobs\CallWebhookJob;

$registration = WebhookRegistration::query()....->first();
$payload = ['my' => 'payload']; // or an object
(new CallWebhookRegistration())->execute($registration, $payload);

// or dispatch a job and let the queue do it
dispatch(new CallWebhookJob($registration, $payload);
```

The job will automatically attempt delivery with exponential backoff delays (e.g., 60s, 120s, 240s…).

---

## 🧪 Testing

Run the package phpunit tests.

```bash
vendor/bin/phpunit
```

---

## 💡 Contributing

Contributions are welcome!  
Please make sure to follow these guidelines:

- Follow PSR-12 and Laravel code style
- Include unit/feature tests for new functionality
- Update documentation for any added or changed behavior

---

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🙋 Contact

For questions, issues, or feature requests, please open a GitHub issue or contact the maintainer directly.
