<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MultiplicationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test success scenario.
     *
     * @param array $matrix1
     * @param array $matrix2
     * @param array $result
     * @return void
     * @group success
     * @group calculate
     * @group feature
     * @dataProvider successDataProvider
     */
    public function testSuccess(array $matrix1, array $matrix2, array $result): void
    {
        $this->actingAsAnAuthenticatedUser();

        $response = $this->postJson(route('api.multiply'), [
            'matrix1' => $matrix1,
            'matrix2' => $matrix2
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson($result);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @group failure
     * @group basic-rules
     * @group validation
     * @group feature
     */
    public function testRequestFailureEmptyBody(): void
    {
        $this->actingAsAnAuthenticatedUser();

        $response = $this->postJson(route('api.multiply'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['matrix1', 'matrix2']);
    }

    /**
     * test validation, non matrix failure
     *
     * @return void
     * @group failure
     * @group matrix-rule
     * @group validation
     * @group feature
     */
    public function testRequestFailureEmptyMatrices(): void
    {
        $this->actingAsAnAuthenticatedUser();

        $response = $this->postJson(route('api.multiply'), [
            'matrix1' => [[], []],
            'matrix2' => [],
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['matrix1.0', 'matrix1.1', 'matrix2']);
    }

    /**
     * test validation, dimension failure
     *
     * @return void
     * @group failure
     * @group multiplicable-rule
     * @group validation
     * @group feature
     */
    public function testRequestDimensionFailure(): void
    {
        $this->actingAsAnAuthenticatedUser();

        $response = $this->postJson(route('api.multiply'), [
            'matrix1' => [[1, 2], [1, 2]],
            'matrix2' => [[2]]
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['matrix1.0']);
    }

    /**
     * test authentication, anonymous user.
     *
     * @return void
     * @group failure
     * @group multiplicable-rule
     * @group authentication
     * @group feature
     */
    public function testAuthenticationFailure(): void
    {
        $response = $this->postJson(route('api.multiply'), [
            'matrix1' => [[1]],
            'matrix2' => [[2]]
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function actingAsAnAuthenticatedUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
    }

    /**
     * Data provider for success scenario test.
     *
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [ // multiply square matrix by an identity matrix
                [
                    [1, 2],
                    [3, 4]
                ],
                [
                    [1, 0],
                    [0, 1]
                ],
                [
                    ['A', 'B'],
                    ['C', 'D']
                ]
            ],
            [ // multiply rectangular matrix by an identity matrix
                [
                    [1, 2, 3],
                    [4, 5, 6]
                ],
                [
                    [1, 0, 0],
                    [0, 1, 0],
                    [0, 0, 1]
                ],
                [
                    ['A', 'B', 'C'],
                    ['D', 'E', 'F']
                ]
            ],
            [ // horizontal matrix by an identity matrix
                [
                    [1, 2, 3],
                ],
                [
                    [1, 0, 0],
                    [0, 1, 0],
                    [0, 0, 1]
                ],
                [
                    ['A', 'B', 'C']
                ]
            ],
            [ // Vertical matrix by an identity matrix
                [
                    [1],
                    [2],
                    [3],
                ],
                [
                    [1]
                ],
                [
                    ['A'],
                    ['B'],
                    ['C']
                ]
            ],
            [ // Singular matrix by another singular matrix
                [
                    [26],
                ],
                [
                    [27]
                ],
                [
                    ['ZZ']
                ]
            ],
            [ // horizontal by vertical
                [
                    [1, 2, 3],
                ],
                [
                    [4],
                    [5],
                    [6],
                ],
                [
                    ['AF']
                ]
            ],
            [ // Vertical by horizontal
                [
                    [1],
                    [2],
                    [3],
                ],
                [
                    [4, 5, 6],
                ],
                [
                    ['D', 'E', 'F'],
                    ['H', 'J', 'L'],
                    ['L', 'O', 'R']
                ]
            ],
            [ // Negative result
                [[-1]],
                [[1]],
                [["-1"]]
            ],
            [ // Zero result
                [[0]],
                [[1]],
                [["0"]]
            ]
        ];
    }
}
