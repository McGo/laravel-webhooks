<?php

namespace McGo\Webhooks\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use McGo\Webhooks\Models\WebhookRegistration;
use McGo\Webhooks\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\Test;

class WebhookRegistrationTests extends BaseTestCase
{
    use RefreshDatabase;
    #[Test]
    public function it_casts_auth_token_to_hidden()
    {
        // Given
        $registration = WebhookRegistration::factory()->create();

        // When & Then
        $this->assertArrayNotHasKey('auth_token', $registration->toArray());
        $this->assertNotNull($registration->auth_token);
    }

    #[Test]
    public function encryption_and_decryption_of_auth_token_work()
    {
        // Given
        $token = Str::random(10);
        $registration = WebhookRegistration::factory()->create([
            'auth_token' => $token
        ]);

        // When accessing via model
        $this->assertEquals($token, $registration->auth_token);

        // When accessing via DB
        $db_token = DB::table('webhook_registrations')
            ->where('id', '=', $registration->id)
            ->value('auth_token');
        $this->assertNotEquals($token, $db_token);
    }
}