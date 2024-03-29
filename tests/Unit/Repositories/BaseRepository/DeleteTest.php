<?php

namespace Tests\Unit\Repositories\BaseRepository;

class DeleteTest extends BaseTestCase
{
    /** @var Stub */
    private $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = new Stub();
        $this->model->name = 'Computer Networks';
        $this->model->author = 'Andrew S. Tanenbaum';
        $this->model->description = 'Appropriate for courses titled Computer Networking or ...';
        $this->model->save();
    }

    /**
     * Test repository delete method (normal behavior).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws \Exception
     */
    public function testDelete()
    {
        $this->stubRepository->delete($this->model);

        $this->assertEquals(0, Stub::query()->get()->count());
    }

    /**
     * Test repository find method (by id).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws \Exception
     */
    public function testDeleteById()
    {
        $this->stubRepository->delete($this->model->id);

        $this->assertEquals(0, Stub::query()->get()->count());
    }
}
