<?php

namespace App\Http\Controllers\UI\Admin\Shares;

use App\Application\Instrument\Share\Query\GetSharesQuery;
use App\Application\Instrument\Share\Query\Handler\GetSharesQueryHandler;
use Inertia\Inertia;
use Inertia\Response;

final readonly class GetSharesBoard
{
    public function __construct(
        private GetSharesQueryHandler $handler
    )
    {
    }

    public function __invoke(): Response
    {
        $query = new GetSharesQuery();
        $shares = ($this->handler)($query);
        dd($shares);
        return Inertia::render('Admin/InstrumentPanel/Shares');
    }
}
