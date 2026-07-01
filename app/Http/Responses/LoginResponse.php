<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginViewResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginResponse implements LoginViewResponse
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): View
    {
        return view('login');
    }
}
