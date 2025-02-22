<?php

namespace App\Domain\Instrument\Share\ValueObject;

readonly final class ShareUidValue
{
  public function __construct(public string $value)
  {
  }

  public function validate(): void
  {

  }

  public function equals(ShareUidValue $shareUidValue): bool
  {

  }

}
