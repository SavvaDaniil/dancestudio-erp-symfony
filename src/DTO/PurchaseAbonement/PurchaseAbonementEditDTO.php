<?php

namespace App\DTO\PurchaseAbonement;

class PurchaseAbonementEditDTO {

    private int $purchaseAbonementId;
    private int $price;
    private int $cashless;
    private int $visitsStart;
    private int $visitsLeft;
    private int $days;
    private ?string $dateOfBuy;
    private ?string $dateOfActivation;
    private ?string $dateOfMustBeUsedTo;
    private ?string $comment;

    public function __construct(
        int $purchaseAbonementId,
        int $price,
        int $cashless,
        int $visitsStart,
        int $visitsLeft,
        int $days,
        ?string $dateOfBuy,
        ?string $dateOfActivation,
        ?string $dateOfMustBeUsedTo,
        ?string $comment
    ){
        $this->purchaseAbonementId = $purchaseAbonementId;
        $this->price = $price;
        $this->cashless = $cashless;
        $this->visitsStart = $visitsStart;
        $this->visitsLeft = $visitsLeft;
        $this->days = $days;
        $this->dateOfBuy = $dateOfBuy;
        $this->dateOfActivation = $dateOfActivation;
        $this->dateOfMustBeUsedTo = $dateOfMustBeUsedTo;
        $this->comment = $comment;
    }



    /**
     * Get the value of purchaseAbonementId
     */ 
    public function getPurchaseAbonementId()
    {
        return $this->purchaseAbonementId;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of cashless
     */ 
    public function getCashless()
    {
        return $this->cashless;
    }

    /**
     * Get the value of visitsStart
     */ 
    public function getVisitsStart()
    {
        return $this->visitsStart;
    }

    /**
     * Get the value of visitsLeft
     */ 
    public function getVisitsLeft()
    {
        return $this->visitsLeft;
    }

    /**
     * Get the value of days
     */ 
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Get the value of dateOfBuy
     */ 
    public function getDateOfBuy()
    {
        return $this->dateOfBuy;
    }

    /**
     * Get the value of dateOfActivation
     */ 
    public function getDateOfActivation()
    {
        return $this->dateOfActivation;
    }

    /**
     * Get the value of dateOfMustBeUsedTo
     */ 
    public function getDateOfMustBeUsedTo()
    {
        return $this->dateOfMustBeUsedTo;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }
}