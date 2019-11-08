<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MultiplicationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->postJson(route('multiply'));

        $response->assertStatus(422);
    }

    public function testRequest()
    {
        $response = $this->postJson(route('multiply'), [
            'matrix1' => [[1, 2], [1, 2]],
            'matrix2' => [[2, 1], [2, 1]]
        ]);

        $response->assertStatus(200);
    }

    public function testRequestFailureEmptyMatrices()
    {
        $response = $this->postJson(route('multiply'), [
            'matrix1' => [[], []],
            'matrix2' => [],
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['matrix1.0', 'matrix1.1', 'matrix2']);
    }

    public function testRequestDimensionFailure()
    {
        $response = $this->postJson(route('multiply'), [
            'matrix1' => [[1, 2], [1, 2]],
            'matrix2' => [[2]]
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['matrix1.0']);
    }
}
