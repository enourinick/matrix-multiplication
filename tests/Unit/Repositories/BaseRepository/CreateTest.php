<?php

namespace Tests\Unit\Repositories\BaseRepository;

use App\Exceptions\RepositoryException;
use Illuminate\Contracts\Container\BindingResolutionException;

class CreateTest extends BaseTestCase
{
    /**
     * Test create resource via repository.
     *
     * @param array $executable
     * @param array $expected
     * @param array|null $fillable
     * @throws RepositoryException
     * @throws BindingResolutionException
     * @dataProvider dataProvider
     * @group unit
     * @group repository
     * @group in-memory-database
     */
    public function testCreate(array $executable, array $expected, array $fillable = null): void
    {
        if (is_null($fillable)) {
            $this->stubRepository->create($executable);
        } else {
            $this->stubRepository->create($executable, $fillable);
        }

        $this->assertEquals($expected, Stub::query()->first(['id', 'name', 'author', 'description'])->toArray());
    }

    public function dataProvider(): array
    {
        return [
            [ // test case 1
                [
                    'name' => 'Head first design patterns',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                ],
                [
                    'id' => 1,
                    'name' => 'Head first design patterns',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                    'description' => null,
                ],
                null
            ],
            [ // test case 2
                [
                    'name' => 'Harry Potter',
                ],
                [
                    'id' => 1,
                    'name' => 'Harry Potter',
                    'author' => null,
                    'description' => null,
                ],
                null
            ],
            [ // test case 3
                [
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ],
                [
                    'id' => 1,
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => null,
                ],
                null
            ],
            [ // test case 4
                [
                    'name' => 'Head first design patterns',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                ],
                [
                    'id' => 1,
                    'name' => 'Head first design patterns',
                    'author' => null,
                    'description' => null,
                ],
                ['name']
            ],
            [ // test case 5
                [
                    'name' => 'Harry Potter',
                ],
                [
                    'id' => 1,
                    'name' => 'Harry Potter',
                    'author' => null,
                    'description' => null,
                ],
                ['name', 'author', 'description']
            ],
            [ // test case 6
                [
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ],
                [
                    'id' => 1,
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ],
                ['name', 'author', 'description']
            ]
        ];
    }
}
