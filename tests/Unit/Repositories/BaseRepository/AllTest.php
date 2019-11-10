<?php

namespace Tests\Unit\Repositories\BaseRepository;


class AllTest extends BaseTestCase
{
    /** @var array */
    private $models = [];

    /**
     * Create a resource by given data.
     *
     * @param string $name
     * @param string $author
     * @param string $description
     * @return Stub
     */
    private function createModel(string $name, string $author, string $description)
    {
        Stub::unguard();
        /** @var Stub $model */
        $model = Stub::query()->create([
            'name' => $name,
            'author' => $author,
            'description' => $description,
        ]);
        Stub::reguard();

        return $model;
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->models[] = $this->createModel('Computer Networks', 'Andrew S. Tanenbaum', 'Appropriate for courses titled Computer Networking or ...')->toArray();
        $this->models[] = $this->createModel('Head first design patterns', 'Kathy Sierra, Elisabeth Freeman', 'What’s so special about design patterns?At any given ...')->toArray();
        $this->models[] = $this->createModel('Harry Potter', 'J. K. Rowling', 'Harry Potter is a series of fantasy novels written by ...')->toArray();
        $this->models[] = $this->createModel('Introduction to Algorithms', 'CLRS', 'Introduction to Algorithms is a book by Thomas H. Cormen ...')->toArray();
    }

    public function tearDown(): void
    {
        foreach ($this->models as $model) {
            Stub::find($model['id'])->delete();
        }

        parent::tearDown();
    }

    /**
     * Test all function from repository.
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     */
    public function testAll(): void
    {
        $result = $this->stubRepository->all();

        $this->assertEquals($this->models, $result->toArray());
    }

    /**
     * Test all function from repository (specific columns).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     */
    public function testAllSpecificColumns(): void
    {
        $result = $this->stubRepository->all(['name', 'author']);

        $expected = [];

        foreach ($this->models as $model) {
            $expected[] = ['name' => $model['name'], 'author' => $model['author']];
        }

        $this->assertEquals($expected, $result->toArray());
    }
}
