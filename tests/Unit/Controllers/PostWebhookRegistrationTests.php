<?php

namespace McGo\Webhooks\Tests\Unit\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use McGo\Webhooks\Controllers\PostWebhookRegistration;
use McGo\Webhooks\Models\WebhookRegistration;
use McGo\Webhooks\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\Test;

class PostWebhookRegistrationTests extends BaseTestCase
{
    use WithFaker, RefreshDatabase;

    #[Test]
    public function it_validates_for_existing_url_field()
    {
        // non existing
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The url field is required');
        $this->postPayload([]);
    }
    #[Test]
    public function it_validates_for_no_correct_payload_url()
    {
        // non existing
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The url field must be a valid URL.');
        $this->postPayload(['url' => 'not a url']);
    }
    #[Test]
    public function it_validates_for_unique_url()
    {
        // Given
        $url = $this->faker->url;
        WebhookRegistration::factory()->create(['url' => $url]);

        // non existing
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The url has already been taken.');
        $this->postPayload(['url' => $url]);
    }


    private function postPayload(array $payload)
    {
        $request = request()->merge($payload);
        return (new PostWebhookRegistration())($request);
    }
}
