<?php

namespace App\DTO\AbonementDynamicDateMustBeUsedTo;

use Symfony\Component\Validator\Constraints as Assert;

class AbonementDynamicDateMustBeUsedToNewDTO{

    #[Assert\NotBlank]
    public int $abonement_id;

    public bool $status;

    public string $date_from_str;

    public string $date_to_str;
}