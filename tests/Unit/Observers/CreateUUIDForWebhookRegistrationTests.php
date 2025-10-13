<?php

namespace McGo\Webhooks\Tests\Unit\Observers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use McGo\Webhooks\Models\WebhookRegistration;
use McGo\Webhooks\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\Test;

class CreateUUIDForWebhookRegistrationTests extends BaseTestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_generates_uuid()
    {
        $registration = WebhookRegistration::factory()->create();
        $this->assertNotEmpty($registration->uuid);
    }
}