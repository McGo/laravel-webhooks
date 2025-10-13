<?php

namespace McGo\Webhooks\Events;

use McGo\Webhooks\Models\WebhookRegistration;

class WebhookSendSuccessfullyEvent
{
    public WebhookRegistration $registration;
    public null|array|object $payload;

    public function __construct(WebhookRegistration $registration, null|array|object $payload = null)
    {
        $this->registration = $registration;
        $this->payload = $payload;
    }
}