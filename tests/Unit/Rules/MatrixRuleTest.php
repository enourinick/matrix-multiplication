<?php

namespace Tests\Unit\Rules;

use App\Rules\MatrixRule;
use Tests\TestCase;

class MatrixRuleTest extends TestCase
{
    /** @var MatrixRule */
    private $matrixRuleInstance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->matrixRuleInstance = resolve(MatrixRule::class);
    }

    /**
     * Test if the rule returns true.
     *
     * @param array $data
     * @return void
     * @group rules
     * @group success
     * @group matrix-rule
     * @group unit
     * @dataProvider successDataProvider
     */
    public function testSuccess(array $data): void
    {
        $this->assertTrue($this->matrixRuleInstance->passes('matrix1', $data));
    }

    /**
     * test false response on non empty 2 dimensional array.
     *
     * @return void
     * @group rules
     * @group failure
     * @group matrix-rule
     */
    public function testFalseOnNonEmpty2DimensionalArray(): void
    {
        $this->assertFalse($this->matrixRuleInstance->passes(
            'matrix1',
            [
                [1, 2, 3],
                [4, 5],
                [7, 8, 9, 13],
                [10, 11, 12],
            ]
        ));
    }

    /**
     * Data provider for success scenario.
     *
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [ // Test one, empty matrix
                [[]]
            ],
            [ // normal multi dimensional matrix
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                    [10, 11, 12],
                ]
            ],
            [ // horizontal matrix
                [
                    [1, 2, 3],
                ]
            ],
            [ // vertical matrix
                [
                    [1],
                    [4],
                    [7],
                    [10],
                ]
            ]
        ];
    }
}
