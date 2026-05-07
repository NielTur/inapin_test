<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if (str_starts_with($request->path(), 'owner')) {
            return route('owner.login');
        }

        // Default → login customer
        return route('login');
    }
}
