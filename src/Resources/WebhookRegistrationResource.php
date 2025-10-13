<?php

namespace McGo\Webhooks\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebhookRegistrationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'url' => $this->url
        ];
    }
}
