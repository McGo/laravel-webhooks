<?php

namespace McGo\Webhooks\Events;

use McGo\Webhooks\Models\WebhookRegistration;

class WebhookSendingFailureEvent
{
    public WebhookRegistration $registration;
    public string $message;
    public null|array|object  $payload;

    public function __construct(WebhookRegistration $registration, null|array|object  $payload = null, string $message = '')
    {
        $this->registration = $registration;
        $this->payload = $payload;
        $this->message = $message;
    }
}