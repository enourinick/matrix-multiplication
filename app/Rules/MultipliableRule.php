<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MultipliableRule implements Rule
{
    private $matrix1;

    /**
     * Create a new rule instance.
     *
     * @param $matrix1
     */
    public function __construct($matrix1)
    {
        $this->matrix1 = $matrix1;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return count($value) === count($this->matrix1);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Matrices are not multipliable because of their dimensions.';
    }
}
