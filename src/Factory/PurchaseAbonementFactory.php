<?php

namespace App\Factory;

use App\Entity\Abonement;
use App\Entity\PurchaseAbonement;
use App\Entity\User;
use DateTime;

class PurchaseAbonementFactory {

    public function create(User $user, Abonement $abonement, int $price, int $cashless, int $visits, int $days, ?string $comment, DateTime $dateOfBuy): PurchaseAbonement {

        $purchaseAbonement = new PurchaseAbonement();
        $purchaseAbonement->setActive(1);
        $purchaseAbonement->setUser($user);
        $purchaseAbonement->setAbonement($abonement);
        $purchaseAbonement->setPrice($price);
        $purchaseAbonement->setCashless($cashless);
        $purchaseAbonement->setVisitsStart($visits);
        $purchaseAbonement->setVisitsLeft($visits);
        $purchaseAbonement->setDays($days);
        $purchaseAbonement->setSpecialStatus($abonement->getSpecialStatus());
        $purchaseAbonement->setComment($comment);

        $dateOfAdd = new DateTime(date("Y-m-d H:i:s"));
        $purchaseAbonement->setDateOfAdd($dateOfAdd);
        $purchaseAbonement->setDateOfBuy($dateOfBuy);

        return $purchaseAbonement;
    }
}