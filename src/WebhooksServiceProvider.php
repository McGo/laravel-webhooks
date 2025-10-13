<?php

namespace McGo\Webhooks;

use Illuminate\Support\ServiceProvider;
use McGo\BoundLessWebhooks\Observers\CreateUUIDForWebhookRegistration;
use McGo\Webhooks\Models\WebhookRegistration;

class WebhooksServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function boot()
    {
        WebhookRegistration::observe(CreateUUIDForWebhookRegistration::class);
    }
}