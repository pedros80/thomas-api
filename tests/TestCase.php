<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAuthHeaders(): array
    {
        return ['Authorization' => 'Bearer ' . config('jwt.test')];
    }
}
