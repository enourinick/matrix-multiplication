<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultiplyRequest;
use App\Services\MultiplyService;
use App\Services\ToExcelColumnNameConverterService;
use Illuminate\Http\JsonResponse;
use App\Tools\ResponseWrapper;

class MultiplyController extends Controller
{
    /**
     * @var MultiplyService
     */
    private $multiplyService;
    /**
     * @var ToExcelColumnNameConverterService
     */
    private $toExcelColumnNameConverterService;

    /**
     * MultiplyController constructor.
     * @param MultiplyService $multiplyService
     * @param ToExcelColumnNameConverterService $toExcelColumnNameConverterService
     */
    public function __construct(
        MultiplyService $multiplyService,
        ToExcelColumnNameConverterService $toExcelColumnNameConverterService
    ) {
        $this->multiplyService = $multiplyService;
        $this->toExcelColumnNameConverterService = $toExcelColumnNameConverterService;
    }

    public function multiply(MultiplyRequest $request): JsonResponse
    {
        $matrix1 = $request->get('matrix1');
        $matrix2 = $request->get('matrix2');

        $result = $this->multiplyService->multiply($matrix1, $matrix2);

        return ResponseWrapper::successObject($this->toExcelColumnNameConverterService->convertMatrix($result));
    }
}
