<?php

namespace Modules\Comment\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Comment\Repositories\CommentRepo;

class ApprovedComment implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $commentRepo = new CommentRepo();
        return ! is_null($commentRepo->findApproved($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
