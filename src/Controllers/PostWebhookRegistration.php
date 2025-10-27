<?php

namespace McGo\Webhooks\Controllers;

use Illuminate\Http\Request;
use McGo\Webhooks\Models\WebhookRegistration;
use McGo\Webhooks\Resources\WebhookRegistrationResource;

class PostWebhookRegistration
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|unique:webhook_registrations,url',
            'auth_header' => 'required|string',
            'auth_token' => 'required|string',
        ]);

        // It is not possible to add two webhook registrations with the same url


        return new WebhookRegistrationResource(WebhookRegistration::create($validated));
    }
}