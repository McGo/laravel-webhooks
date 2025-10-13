<?php

namespace McGo\Webhooks\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use McGo\Webhooks\Models\WebhookRegistration;

class WebhookRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebhookRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url,
            'auth_header' => $this->faker->word,
            'auth_token' => Str::random(64),
            'registered_by_ip' => $this->faker->ipv4,
            'registered_by_user_agent' => $this->faker->userAgent,
        ];
    }
}