<?php

namespace McGo\Webhooks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use McGo\Webhooks\Factories\WebhookRegistrationFactory;

class WebhookRegistration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'webhook_registrations';
    protected $fillable = [
        'uuid',
        'url',
        'auth_header',
        'auth_token',
        'registered_by_ip',
        'registered_by_user_agent'
    ];

    protected $hidden = [
        'auth_token'
    ];

    protected function casts(): array
    {
        return [
            'auth_token' => 'encrypted',
        ];
    }

    public static function newFactory()
    {
        return new WebhookRegistrationFactory();
    }
}