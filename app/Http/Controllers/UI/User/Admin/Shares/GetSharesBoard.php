<?php

namespace App\Http\Controllers\UI\User\Admin\Shares;

use Inertia\Inertia;
use Inertia\Response;

final readonly class GetSharesBoard
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/InstrumentPanel/Shares');
    }
}
