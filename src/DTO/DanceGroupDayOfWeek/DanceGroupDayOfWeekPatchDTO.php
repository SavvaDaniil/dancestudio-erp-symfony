<?php

namespace App\DTO\DanceGroupDayOfWeek;

class DanceGroupDayOfWeekPatchDTO {

    private int $dance_group_day_of_week_id;
    private string $name;
    private string $value;

    public function __construct(int $dance_group_day_of_week_id, string $name, string $value){
        $this->dance_group_day_of_week_id = $dance_group_day_of_week_id;
        $this->name = $name;
        $this->value = $value;
    }


    /**
     * Get the value of dance_group_day_of_week_id
     */ 
    public function getDance_group_day_of_week_id(): int
    {
        return $this->dance_group_day_of_week_id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of value
     */ 
    public function getValue(): string
    {
        return $this->value;
    }
}