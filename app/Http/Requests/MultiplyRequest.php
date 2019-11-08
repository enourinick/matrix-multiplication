<?php

namespace App\Http\Requests;

use App\Rules\MatrixRule;
use App\Rules\MultipliableRule;

class MultiplyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    protected function postRules()
    {
        return [
            'matrix1' => ['required', 'array', 'min:1', new MatrixRule()],
            'matrix1.*' => ['array', 'min:1'],
            'matrix1.0' => ['array', 'min:1', new MultipliableRule($this->get('matrix2'))],
            'matrix2' => ['required', 'array', 'min:1', new MatrixRule()],
            'matrix2.*' => ['array', 'min:1'],
        ];
    }
}
