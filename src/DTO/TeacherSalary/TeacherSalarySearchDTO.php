<?php


namespace App\DTO\TeacherSalary;

class TeacherSalarySearchDTO {

    private ?string $dateFrom;
    private ?string $dateTo;
    private int $danceGroupId;
    private int $teacherId;

    public function __construct(
        ?string $dateFrom,
        ?string $dateTo,
        int $danceGroupId,
        int $teacherId
    ){
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->danceGroupId = $danceGroupId;
        $this->teacherId = $teacherId;
    }

    /**
     * Get the value of dateFrom
     */ 
    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    /**
     * Get the value of dateTo
     */ 
    public function getDateTo(): ?string
    {
        return $this->dateTo;
    }

    /**
     * Get the value of danceGroupId
     */ 
    public function getDanceGroupId(): int
    {
        return $this->danceGroupId;
    }

    /**
     * Get the value of teacherId
     */ 
    public function getTeacherId(): int
    {
        return $this->teacherId;
    }
}