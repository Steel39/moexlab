<?php

namespace App\Http\Controllers\UI\Admin\Stream;

use Inertia\Inertia;

class StreamController
{
    public function __invoke()
    {
        return Inertia::render('Admin/InstrumentPanel/Streams');
    }
}
