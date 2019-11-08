<?php

namespace Tests\Unit\Rules;

use App\Rules\MatrixRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
     * @return void
     * @group rules
     * @group success
     * @group matrix-rule
     * @dataProvider successDataProvider
     */
    public function testTrueOnEmptyMatrix($data)
    {
        $this->assertTrue($this->matrixRuleInstance->passes('matrix1', $data));
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @group rules
     * @group failure
     * @group matrix-rule
     */
    public function testFalseOnNonEmptyMatrix()
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

    public function successDataProvider() {
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
