<?php


namespace App\Facade;

use DateTime;
use App\Repository\AbonementDynamicDateMustBeUsedToRepository;
use App\DTO\AbonementDynamicDateMustBeUsedTo\AbonementDynamicDateMustBeUsedToNewDTO;
use App\ViewModel\JsonAnswerStatus;

class AbonementDynamicDateMustBeUsedToFacade {

    public function __construct(
        private AbonementDynamicDateMustBeUsedToRepository $abonementDynamicDateMustBeUsedToRepository,
    ){

    }

    /*
    public function add(AbonementDynamicDateMustBeUsedToNewDTO $abonementDynamicDateMustBeUsedToNewDTO): JsonAnswerStatus {


    }
    */

}