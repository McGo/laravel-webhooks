<?php

namespace McGo\Webhooks\Actions;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use McGo\Webhooks\Models\WebhookRegistration;

class CallWebhookRegistration
{
    /**
     * @throws ConnectionException
     */
    public function execute(WebhookRegistration $registration, null|array|object $payload): void
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        if (!is_null($registration->auth_header) && !is_null($registration->auth_token)) {
            $headers[$registration->auth_header] = $registration->auth_token;
        }
        $response = Http::withHeaders($headers)
            ->timeout(10)
            ->post($registration->url, $payload);
        if ($response->failed()) {
            throw new \Exception("CallWebhookJob::Call failed for url {$registration->url} ({$response->status()})");
        }
    }
}