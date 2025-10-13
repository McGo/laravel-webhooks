<?php

namespace McGo\BoundLessWebhooks\Jobs;

use McGo\Webhooks\Models\WebhookRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CallWebhookJob  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private WebhookRegistration $registration;
    private null|array|object $payload;

    public $tries = 10;

    private int $attempt;

    public function __construct(WebhookRegistration $registration, null|array|object $payload, $attempt = 1)
    {
        $this->payload = $payload;
        $this->registration = $registration;
        $this->attempt = $attempt;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        Log::info('CallWebhookJob:Calling webhook '.$this->registration->uuid.' - attempt '.$this->attempt);
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        if (!is_null($this->registration->auth_header) && !is_null($this->registration->auth_token)) {
            $headers[$this->registration->auth_header] = $this->registration->auth_token;
        }
        $response = Http::withHeaders($headers)
            ->timeout(10)
            ->post($this->registration->url, $this->payload);
        if ($response->failed()) {
            throw new \Exception("CallWebhookJob::Call failed for url {$this->registration->url} ({$response->status()})");
        }
    }

    public function backoff(): array
    {
        return collect(range(1, $this->tries))
            ->map(fn($i) => 60 * pow(2, $i - 1) + rand(0, 30))
            ->all();
    }
}