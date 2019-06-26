<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Store user into DB and login with him
     *
     * @var User
     */
    protected $user;

    protected function loginWithFakeUser(array $userData = []): User
    {
        $this->user = factory(User::class)->create($userData);
        $this->actingAs($this->user, 'web');

        return $this->user;
    }
}
