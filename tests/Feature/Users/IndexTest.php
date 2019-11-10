<?php

namespace Tests\Feature\Users;

use App\Tools\Setting;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test index users.
     *
     * @return void
     * @group user
     * @group feature
     */
    public function testIndexUsers()
    {
        factory(User::class, Setting::PAGE_SIZE * 2 + 1)->create();

        $response = $this->getJson(route('api.user.index'));

        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            'total',
            'data',
            'from',
            'to',
            'data' => [
                '*' => [
                    'name',
                    'email',
                    'id'
                ]
            ]
        ]);
    }
}
