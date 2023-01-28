<?php

namespace App\DTO\PurchaseAbonement;


class PurchaseAbonementNewDTO {
    
    private int $userId;
    private int $abonementId;
    private int $danceGroupId;
    private int $price;
    private int $cashless;
    private int $visits;
    private int $days;
    private ?string $comment;
    private string $dateOfAddStr;

    public function __construct(
        int $userId,
        int $abonementId,
        int $danceGroupId,
        int $price,
        int $cashless,
        int $visits,
        int $days,
        ?string $comment,
        string $dateOfAddStr
    ){
        $this->userId = $userId;
        $this->abonementId = $abonementId;
        $this->danceGroupId = $danceGroupId;
        $this->price = $price;
        $this->cashless = $cashless;
        $this->visits = $visits;
        $this->days = $days;
        $this->comment = $comment;
        $this->dateOfAddStr = $dateOfAddStr;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Get the value of abonementId
     */ 
    public function getAbonementId(): int
    {
        return $this->abonementId;
    }

    /**
     * Get the value of danceGroupId
     */ 
    public function getDanceGroupId()
    {
            return $this->danceGroupId;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Get the value of cashless
     */ 
    public function getCashless(): int
    {
        return $this->cashless;
    }

    /**
     * Get the value of visits
     */ 
    public function getVisits(): int
    {
        return $this->visits;
    }

    /**
     * Get the value of days
     */ 
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Get the value of dateOfAddStr
     */ 
    public function getDateOfAddStr(): string
    {
        return $this->dateOfAddStr;
    }
}