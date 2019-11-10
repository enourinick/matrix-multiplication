<?php

namespace Tests\Unit\Services;

use App\Services\MultiplyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MultiplyServiceTest extends TestCase
{
    /** @var MultiplyService */
    private $multiplyService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->multiplyService = resolve(MultiplyService::class);
    }

    /**
     * test success.
     *
     * @param array $matrix1
     * @param array $matrix2
     * @param array $expected
     * @return void
     * @group services
     * @group success
     * @group multiply-service
     * @group unit
     * @group calculate
     * @dataProvider successDataProvider
     */
    public function testSuccess(array $matrix1, array $matrix2, array $expected): void
    {
        $this->assertEquals($expected, $this->multiplyService->multiply($matrix1, $matrix2));
    }

    /**
     * Data provider for successful scenario.
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
                    [1, 2],
                    [3, 4]
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
                    [1, 2, 3],
                    [4, 5, 6]
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
                    [1, 2, 3],
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
                    [1],
                    [2],
                    [3],
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
                    [702]
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
                    [32]
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
                    [4, 5, 6],
                    [8, 10, 12],
                    [12, 15, 18]
                ]
            ],
            [ // two empty arrays
                [[]],
                [[]],
                []
            ]
        ];
    }
}
