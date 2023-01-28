<?php

namespace App\Factory;

use App\Entity\DanceGroup;
use App\Entity\DanceGroupDayOfWeek;
use App\Entity\PurchaseAbonement;
use App\Entity\User;
use App\Entity\Visit;
use DateTime;

class VisitFactory {

    public function createByAdmin(User $user, DanceGroup $danceGroup, DanceGroupDayOfWeek $danceGroupDayOfWeek, PurchaseAbonement $purchaseAbonement, string $dateOfActionStr): Visit {
        $visit = new Visit();

        $dateOfAdd = new DateTime(date("Y-m-d H:i:s"));
        //print("VisitFactory dateOfAction: " . $dateOfAction->format("Y-m-d H:i:s"));
        $visit->setDateOfBuy(new DateTime(date($dateOfActionStr)));
        $visit->setDateOfAdd($dateOfAdd);
        $visit->setUser($user);
        $visit->setDanceGroup($danceGroup);
        $visit->setDanceGroupDayOfWeek($danceGroupDayOfWeek);
        $visit->setPurchaseAbonement($purchaseAbonement);
        $visit->setSpecialStatusOfAbonement($purchaseAbonement->getSpecialStatus());
        $visit->setIsAddByApp(0);
        $visit->setIsReservation(0);
        $visit->setStatusOfReservation(0);
        $visit->setVisitsLeft($purchaseAbonement->getVisitsLeft() - 1);

        return $visit;
    }

}