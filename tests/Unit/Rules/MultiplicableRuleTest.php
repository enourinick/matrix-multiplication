<?php

namespace Tests\Unit\Rules;

use App\Rules\MultipliableRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MultiplicableRuleTest extends TestCase
{
    /**
     * Test success.
     *
     * @return void
     * @group rules
     * @group success
     * @group multiplicable-rule
     * @dataProvider successDataProvider
     */
    public function testSuccess(array $firstRow, array $matrix)
    {
        $multiplicableRuleInstance = new MultipliableRule($matrix);

        $this->assertTrue($multiplicableRuleInstance->passes('matrix1.0', $firstRow));
    }

    /**
     * Test failure.
     *
     * @return void
     * @group rules
     * @group failure
     * @group multiplicable-rule
     * @dataProvider failureDataProvider
     */
    public function testFailure(array $firstRow, array $matrix)
    {
        $multiplicableRuleInstance = new MultipliableRule($matrix);

        $this->assertFalse($multiplicableRuleInstance->passes('matrix1.0', $firstRow));
    }

    public function successDataProvider()
    {
        return [
            [ // empty first row on an empty array
                [],
                []
            ],
            [ // single element first row on single element matrix
                [1],
                [[2]]
            ],
            [ // single element first row on horizontal matrix
                [1],
                [[2, 3, 4]]
            ],
            [ // 3 elements first row on 3x2 matrix
                [1, 2, 3],
                [
                    [4, 5],
                    [6, 7],
                    [8, 9]
                ]
            ],
            [ // 3 elements first row on vertical matrix
                [1, 2, 3],
                [
                    [4],
                    [5],
                    [6]
                ]
            ],
        ];
    }

    public function failureDataProvider()
    {
        return [
            [ // empty first row on an empty matrix
                [],
                [[]]
            ],
            [ // empty first row on single element matrix
                [],
                [[2]]
            ],
            [ // single element first row on vertical element matrix
                [1],
                [
                    [2],
                    [3],
                    [4]
                ]
            ],
            [ // 3 elements first row on 2x3 matrix
                [1, 2, 3],
                [
                    [4, 5, 6],
                    [7, 8, 9]
                ]
            ],
            [ // 3 elements first row on horizontal matrix
                [1, 2, 3],
                [
                    [4, 5, 6]
                ]
            ],
        ];
    }
}
