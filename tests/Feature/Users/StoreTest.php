<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test store user.
     *
     * @return void
     * @group success
     * @group user
     * @group feature
     */
    public function testStoreUser()
    {
        /** @var User $user */
        $user = factory(User::class)->make(['password' => 'secret']);

        $response = $this->postJson(route('api.user.store'), $user->only('name', 'email', 'password'));

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('users', $user->only('email', 'name'));

        $user = User::query()->where('email', $user->email)->first();

        $this->assertTrue(Hash::check('secret', $user->password));
    }

    /**
     * Test store user failure because of empty body.
     *
     * @return void
     * @group failure
     * @group validation
     * @group user
     * @group feature
     */
    public function testEmptyBodyFailure()
    {
        $response = $this->postJson(route('api.user.store'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Test store user failure because of duplicate email.
     *
     * @return void
     * @group failure
     * @group validation
     * @group user
     * @group feature
     */
    public function testDuplicateEmailFailure()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var User $user */
        $userForStore = factory(User::class)->make(['password' => 'secret', 'email' => $user->email]);

        $response = $this->postJson(route('api.user.store'), $userForStore->only('name', 'email', 'password'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }
}
