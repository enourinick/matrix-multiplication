<?php

namespace Tests\Unit\Services;

use App\Exceptions\RepositoryException;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    /**
     * Test index method.
     *
     * @return void
     * @group services
     * @group user-service
     * @group unit
     */
    public function testIndex(): void
    {
        $this->mock(UserRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('paginate')
                ->once();
        });

        /** @var UserService $userService */
        $userService = resolve(UserService::class);
        $userService->index();

        $this->assertTrue(true);
    }

    /**
     * Test store method.
     *
     * @return void
     * @throws RepositoryException
     * @throws BindingResolutionException
     * @group services
     * @group user-service
     * @group unit
     */
    public function testStore(): void
    {
        $data = ['name' => $this->faker->name];

        $this->mock(UserRepository::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('create')
                ->withArgs([$data])
                ->once();
        });

        /** @var UserService $userService */
        $userService = resolve(UserService::class);
        $userService->store($data);

        $this->assertTrue(true);
    }

    /**
     * Test update method.
     *
     * @return void
     * @group services
     * @group user-service
     * @group unit
     */
    public function testUpdate(): void
    {
        $data = ['name' => $this->faker->name];
        $user = factory(User::class)->create();

        $this->mock(UserRepository::class, function (MockInterface $mock) use ($user, $data) {
            $mock->shouldReceive('update')
                ->withArgs([$data, $user])
                ->once();
        });

        /** @var UserService $userService */
        $userService = resolve(UserService::class);
        $userService->update($data, $user);

        $this->assertTrue(true);
    }

    /**
     * Test show method.
     *
     * @return void
     * @group services
     * @group user-service
     * @group unit
     */
    public function testShow(): void
    {
        $user = factory(User::class)->create();

        $this->mock(UserRepository::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('load')
                ->withArgs([$user])
                ->once();
        });

        /** @var UserService $userService */
        $userService = resolve(UserService::class);
        $userService->show($user);

        $this->assertTrue(true);
    }
}
