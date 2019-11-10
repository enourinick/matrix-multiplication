<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MultipliableRule implements Rule
{
    private $matrix2;

    /**
     * Create a new rule instance.
     *
     * @param $matrix2
     */
    public function __construct($matrix2)
    {
        $this->matrix2 = $matrix2;
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
        return is_array($this->matrix2) && count($value) === count($this->matrix2);
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
