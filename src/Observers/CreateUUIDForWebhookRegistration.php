<?php

namespace McGo\Webhooks\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use McGo\Webhooks\Models\WebhookRegistration;

class CreateUUIDForWebhookRegistration
{
    public function creating(WebhookRegistration $webhookRegistration)
    {
        $webhookRegistration->uuid = Str::uuid();
        $webhookRegistration->registered_by_ip = request()->ip();
        $webhookRegistration->registered_by_user_agent = request()->userAgent();
    }
}