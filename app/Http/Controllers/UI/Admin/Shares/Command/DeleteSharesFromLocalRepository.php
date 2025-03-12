<?php

namespace App\Http\Controllers\UI\Admin\Shares\Command;

use App\Application\Instrument\Share\Command\DeleteSharesCommand;
use App\Application\Instrument\Share\Command\Handler\DeleteSharesCommandHandler;
use Illuminate\Http\RedirectResponse;

class DeleteSharesFromLocalRepository
{
    public function __construct(
        private readonly DeleteSharesCommandHandler $handler
    )
    {

    }

    public function __invoke(): RedirectResponse
    {
        ($this->handler)(new DeleteSharesCommand());
        return redirect()->back();
    }
}
