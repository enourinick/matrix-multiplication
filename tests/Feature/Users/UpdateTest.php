<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test update user.
     *
     * @return void
     * @group success
     * @group user
     * @group feature
     */
    public function testSuccess()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $newUser = factory(User::class)->make(['password' => 'secret']);

        $response = $this->actingAs($user)
            ->putJson(route('api.me.update'), $newUser->only('name', 'email', 'password'));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('users', array_merge($newUser->only('email', 'name'), $user->only('id')));

        $user->refresh();

        $this->assertTrue(Hash::check('secret', $user->password));
    }

    /**
     * Test update user failure because of duplicate email.
     *
     * @return void
     * @group failure
     * @group validation
     * @group user
     * @group feature
     */
    public function testUpdateUser()
    {
        /** @var User $anotherUser */
        $anotherUser = factory(User::class)->create();
        /** @var User $user */
        $user = factory(User::class)->create();
        $newUser = factory(User::class)->make(['password' => 'secret', 'email' => $anotherUser->email]);

        $response = $this->actingAs($user)
            ->putJson(route('api.me.update'), $newUser->only('name', 'email', 'password'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }
}
