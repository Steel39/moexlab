<?php

namespace App\Application\Instrument\Share\Command\Handler;

use App\Application\Instrument\Share\Command\SaveSharesCommand;
use App\Domain\Entity\Instrument\Share;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;
use InvalidArgumentException;

readonly class SaveSharesCommandHandler
{
    public function __construct(
        private WriteShareRepositoryInterface $instrumentRepository
    ) {
    }

    /**
     * Обрабатывает команду сохранения акций.
     *
     * @param SaveSharesCommand $command Команда с массивом акций для сохранения.
     * @return int Количество сохраненных акций.
     * @throws InvalidArgumentException Если данные в команде некорректны.
     */
    public function __invoke(SaveSharesCommand $command): int
    {
        $shares = $command->getShares();

        if (empty($shares)) {
            throw new InvalidArgumentException("The shares array in the command is empty.");
        }

        foreach ($shares as $share) {
            if (!$share instanceof Share) {
                throw new InvalidArgumentException("All elements in the shares array must be instances of Share.");
            }
        }

        return $this->instrumentRepository->saveAll($shares);
    }
}
