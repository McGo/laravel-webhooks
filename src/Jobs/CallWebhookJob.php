<?php

namespace McGo\Webhooks\Jobs;

use McGo\Webhooks\Actions\CallWebhookRegistration;
use McGo\Webhooks\Models\WebhookRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
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


    public function __construct(WebhookRegistration $registration, null|array|object $payload)
    {
        $this->payload = $payload;
        $this->registration = $registration;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        Log::info('CallWebhookJob:Calling webhook '.$this->registration->uuid);
        (new CallWebhookRegistration())->execute($this->registration, $this->payload);
    }

    public function backoff(): array
    {
        return collect(range(1, $this->tries))
            ->map(fn($i) => 60 * pow(2, $i - 1) + rand(0, 30))
            ->all();
    }
}