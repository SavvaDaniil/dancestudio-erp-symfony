<?php


namespace App\DTO\Visit;

class VisitNewDTO {

    private int $userId;
    private int $danceGroupId;
    private int $purchaseAbonementId;
    private string $dateOfActionStr;

    public function __construct(
        int $userId,
        int $danceGroupId,
        int $purchaseAbonementId,
        string $dateOfActionStr
    )
    {
        $this->userId = $userId;
        $this->danceGroupId = $danceGroupId;
        $this->purchaseAbonementId = $purchaseAbonementId;
        $this->dateOfActionStr = $dateOfActionStr;
    }
    

    /**
     * Get the value of userId
     */ 
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Get the value of danceGroupId
     */ 
    public function getDanceGroupId(): int
    {
        return $this->danceGroupId;
    }

    /**
     * Get the value of purchaseAbonementId
     */ 
    public function getPurchaseAbonementId(): int
    {
        return $this->purchaseAbonementId;
    }

    /**
     * Get the value of dateOfActionStr
     */ 
    public function getDateOfActionStr(): string
    {
        return $this->dateOfActionStr;
    }
}