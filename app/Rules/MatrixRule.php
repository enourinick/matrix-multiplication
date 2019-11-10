<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MatrixRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $columnCount = null;

        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $row) {
            if ($columnCount === null) {
                $columnCount = count($row);
            } else {
                if ($columnCount !== count($row)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute field is not a matrix';
    }
}
