<?php

namespace App\Console\Commands\Test;

use App\Application\Instrument\Share\Command\DeleteShares\DeleteSharesCommand;
use App\Application\Instrument\Share\Command\DeleteShares\Handler\DeleteSharesCommandHandler;
use App\Application\Instrument\Share\Command\Handler\UpdateWeeklyVolumesCommandHandler;
use App\Application\Instrument\Share\Command\UpdateWeeklyVolumesCommand;
use App\Domain\Repositories\Instrument\Share\ApiShareRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;
use App\Domain\ValueObjects\InstrumentUid;
use App\Infrastructure\Repositories\TInvestApi\Instrument\Shares\TInvestSharesRepository;
use App\Infrastructure\Repositories\TInvestApi\Market\GetCandleByInterval;
use Illuminate\Console\Command;
use Tinderbox\ClickhouseBuilder\Exceptions\Exception;
use Google\Protobuf\Timestamp;

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
    public function handle(UpdateWeeklyVolumesCommandHandler $handler): void
    {
        $this->info('Начинаем обновление недельных объемов...');

        // Создаем команду и передаем её обработчику
        $command = new UpdateWeeklyVolumesCommand();
        ($handler)($command);

        $this->info('Обновление недельных объемов завершено.');
    }
}
