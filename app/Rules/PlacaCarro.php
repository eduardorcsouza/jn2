<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PlacaCarro implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^([A-Z]{3})([0-9])([0-9A-Z])([0-9]{2})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute não possui um formato válido de placa de veículo.';
    }
}
