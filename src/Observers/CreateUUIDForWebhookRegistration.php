<?php

namespace McGo\BoundLessWebhooks\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use McGo\BoundLessWebhooks\Models\WebhookRegistration;

class CreateUUIDForWebhookRegistration
{
    public function creating(WebhookRegistration $webhookRegistration)
    {
        $webhookRegistration->uuid = Str::uuid();
        $webhookRegistration->registered_by_ip = request()->ip();
        $webhookRegistration->registered_by_user_agent = request()->userAgent();
        $webhookRegistration->user_id = Auth::id();
    }
}