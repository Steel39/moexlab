<?php

namespace App\Http\Controllers\UI\User;

use Inertia\Inertia;

class WelcomeController
{
    public function __invoke()
    {
        return Inertia::render('Guest/Pages/Index', []);
    }
}
