<?php

namespace Tests\Unit\Repositories\BaseRepository;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

abstract class BaseTestCase extends TestCase
{
    /** @var StubRepository */
    public $stubRepository;

    public function setUp(): void
    {
        parent::setUp();

        Config::set(
            'database.connections.in-memory-test-db', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'charset' => 'utf8',
            'prefix' => '',
        ]);

        Schema::connection('in-memory-test-db')->create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $this->stubRepository = resolve(StubRepository::class);
    }

    public function tearDown(): void
    {
        Schema::connection('in-memory-test-db')->drop('books');

        parent::tearDown();
    }
}

class Stub extends Model
{
    protected $connection = 'in-memory-test-db';
    protected $table = 'books';
}

class StubRepository extends BaseRepository
{
    protected $fillable = [
        'name',
        'author',
    ];

    /**
     * Return model class path.
     *
     * @return string
     */
    protected function model()
    {
        return Stub::class;
    }
}
