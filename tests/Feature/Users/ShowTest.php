<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test show user.
     *
     * @return void
     * @group user
     * @group feature
     */
    public function testShowUser()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->getJson(route('api.me.show'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson($user->only('name', 'email', 'id'));
    }
}
