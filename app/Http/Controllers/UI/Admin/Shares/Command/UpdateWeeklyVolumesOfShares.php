<?php

namespace App\Http\Controllers\UI\Admin\Shares\Command;

use App\Application\Instrument\Share\Command\Handler\UpdateWeeklyVolumesCommandHandler;
use App\Application\Instrument\Share\Command\UpdateWeeklyVolumesCommand;
use Illuminate\Http\RedirectResponse;

final readonly class UpdateWeeklyVolumesOfShares
{
    public function __construct(
        private readonly UpdateWeeklyVolumesCommandHandler $handler
    )
    {

    }

    public function __invoke(): RedirectResponse
    {
        try {
            ($this->handler)(new UpdateWeeklyVolumesCommand());
            return redirect()->back()->with('success', 'Недельные объемы всех акций успешно обновлены.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
