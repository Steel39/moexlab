<?php

namespace App\Http\Controllers\UI\Admin\Shares\Command;

use App\Application\Instrument\Share\Command\Handler\SaveSharesCommandHandler;
use App\Application\Instrument\Share\Command\SaveSharesCommand;
use App\Application\Instrument\Share\Query\GetSharesFromApi\GetSharesApiQuery;
use App\Application\Instrument\Share\Query\GetSharesFromApi\Hanlder\GetSharesApiQueryHandler;
use Illuminate\Http\RedirectResponse;
final readonly class SaveSharesFromApi
{
    public function __construct(
        private readonly GetSharesApiQueryHandler $apiHandler,
        private readonly SaveSharesCommandHandler $commandHandler
    )
    {

    }

    public function __invoke(): RedirectResponse
    {
        $apiShares = ($this->apiHandler)(new GetSharesApiQuery());
        $command = new SaveSharesCommand($apiShares);
        ($this->commandHandler)($command);
        return redirect()->back()->with(['sucess' => 'Акции удалены']);
    }
}

