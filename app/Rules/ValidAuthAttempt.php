<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ValidAuthAttempt implements Rule
{
    /**
     * @var \App\Models\AuthRequest
     */
    public $request;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new rule instance.
     *
     * @param \App\Models\AuthRequest $request
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
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
        return $this->request->user_id == $this->user->id && Hash::check($value, $this->request->token);
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
