<?php

namespace App\DTO\Visit;

class VisitPrepareDTO {

    private int $userId;
    private int $danceGroupId;
    private string $dateOfActionStr;

    public function __construct(
        int $userId,
        int $danceGroupId,
        string $dateOfActionStr
    )
    {
        $this->userId = $userId;
        $this->danceGroupId = $danceGroupId;
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
     * Get the value of dateOfActionStr
     */ 
    public function getDateOfActionStr()
    {
        return $this->dateOfActionStr;
    }
}