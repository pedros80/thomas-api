<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAuthHeaders(): array
    {
        return ['Authorization' => 'Bearer ' . Config::get('jwt.test')];
    }
}
