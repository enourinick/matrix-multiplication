<?php

namespace Tests\Unit\Services;

use App\Services\ToExcelColumnNameConverterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToExcelColumnNameConverterServiceTest extends TestCase
{
    /** @var ToExcelColumnNameConverterService */
    private $toExcelColumnNameConverterService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->toExcelColumnNameConverterService = resolve(ToExcelColumnNameConverterService::class);
    }

    /**
     * A basic unit test example.
     *
     * @param int $number
     * @param string $expected
     * @return void
     * @group services
     * @group success
     * @group to-excel-column-name-converter-service
     * @group unit
     * @group calculate
     * @dataProvider getExcelColumnNameDataProvider
     */
    public function testGetExcelColumnName(int $number, string $expected): void
    {
        $this->assertEquals($expected, $this->toExcelColumnNameConverterService->getExcelColumnName($number));
    }

    /**
     * A basic unit test example.
     *
     * @param array $vector
     * @param array $expected
     * @return void
     * @group services
     * @group success
     * @group to-excel-column-name-converter-service
     * @group unit
     * @group calculate
     * @dataProvider convertVectorDataProvider
     */
    public function testConvertVector(array $vector, array $expected): void
    {
        $this->assertEquals($expected, $this->toExcelColumnNameConverterService->convertVector($vector));
    }

    /**
     * A basic unit test example.
     *
     * @param array $vector
     * @param array $expected
     * @return void
     * @group services
     * @group success
     * @group to-excel-column-name-converter-service
     * @group unit
     * @group calculate
     * @dataProvider convert2DimensionalArrayDataProvider
     */
    public function testConvert2DimensionalArray(array $vector, array $expected): void
    {
        $this->assertEquals($expected, $this->toExcelColumnNameConverterService->convertMatrix($vector));
    }

    /**
     * Data provider for get excel column name by a numeric input.
     *
     * @return array
     */
    public function getExcelColumnNameDataProvider(): array
    {
        return [
            [1, 'A'],
            [26, 'Z'],
            [27, 'AA'],
            [32, 'AF'],
            [52, 'AZ'],
            [676, 'YZ'],
            [702, 'ZZ'],
            [703, 'AAA'],
            [0, "0"],
            [-20, "-20"],
        ];
    }

    /**
     * Data provider for convert vector data.
     *
     * @return array
     */
    public function convertVectorDataProvider()
    {
        return [
            [ // vector
                [1,26, 27, 32, 52, 676, 702, 703],
                ['A', 'Z', 'AA', 'AF', 'AZ', 'YZ', 'ZZ', 'AAA']
            ],
            [ // empty vector
                [],
                []
            ],
            [ // vector with single element
                [52],
                ['AZ']
            ]
        ];
    }

    /**
     * Data provider for convert 2 dimensional array.
     *
     * @return array
     */
    public function convert2DimensionalArrayDataProvider()
    {
        return [
            [ // Matrix
                [
                    [1,26, 27],
                    [32, 52, 676],
                    [702, 703, 2],
                ],
                [
                    ['A', 'Z', 'AA'],
                    ['AF', 'AZ', 'YZ'],
                    ['ZZ', 'AAA', 'B'],
                ]
            ],
            [ // empty matrix
                [[]],
                [[]]
            ],
            [ // 2 dimensional array
                [
                    [1,26, 27],
                    [32, 52],
                    [702, 703, 2, 676],
                ],
                [
                    ['A', 'Z', 'AA'],
                    ['AF', 'AZ'],
                    ['ZZ', 'AAA', 'B', 'YZ'],
                ]
            ]
        ];
    }
}
