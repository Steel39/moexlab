<?php

namespace App\Domain\Repositories\Share\ValueObject;

final readonly class ShareNameCompanyValue
{
    public function __construct(public string $companyName)
    {
    }

}
