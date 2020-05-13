<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ValidAuthToken implements Rule
{
    /**
     * @var string
     */
    public $hashedToken;

    /**
     * Create a new rule instance.
     *
     * @param string $hashedToken
     * @return void
     */
    public function __construct($hashedToken)
    {
        $this->hashedToken = $hashedToken;
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
        return Hash::check($value, $this->hashedToken);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This code is invalid. Please check it\'s what we sent you.';
    }
}
