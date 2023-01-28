<?php

namespace App\DTO\DanceGroupDayOfWeek;

class DanceGroupDayOfWeekNewDTO {

    private int $dance_group_id;
    private bool $is_event;

    public function __construct(int $dance_group_id, bool $is_event)
    {
        $this->dance_group_id = $dance_group_id;
        $this->is_event = $is_event;
    }

    /**
     * Get the value of dance_group_id
     */ 
    public function getDance_group_id(): int
    {
        return $this->dance_group_id;
    }

    /**
     * Get the value of is_event
     */ 
    public function getIs_event()
    {
        return $this->is_event;
    }
}