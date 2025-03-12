<?php

namespace App\Console\Commands\Test;

use App\Application\Instrument\Share\Command\DeleteShares\DeleteSharesCommand;
use App\Application\Instrument\Share\Command\DeleteShares\Handler\DeleteSharesCommandHandler;
use App\Domain\Repositories\Instrument\Share\ApiShareRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;
use App\Infrastructure\Repositories\TInvestApi\Instrument\Shares\TInvestSharesRepository;
use Illuminate\Console\Command;
use Tinderbox\ClickhouseBuilder\Exceptions\Exception;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(WriteShareRepositoryInterface $handler): void
    {
        $handler->deleteAll();
    }
}
