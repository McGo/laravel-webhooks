<?php

namespace McGo\Webhooks\Tests;

use McGo\Webhooks\WebhooksServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase  extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            WebhooksServiceProvider::class,
        ];
    }

}