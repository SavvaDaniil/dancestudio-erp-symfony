<?php

namespace App\DTO\DanceGroup;

class DanceGroupEditDTO {
    
    private int $dance_group_id;
    private ?string $name;
    private int $teacher_id;
    private ?string $description;
    private int $status;
    private int $status_for_app;
    private int $status_of_creative;
    private int $branch_id;
    private int $is_active_reservation;
    private int $is_event;
    private int $is_abonements_allow_all;

    public function __construct(
        int $dance_group_id,
        ?string $name,
        int $teacher_id,
        ?string $description,
        int $status,
        int $status_for_app,
        int $status_of_creative,
        int $branch_id,
        int $is_active_reservation,
        int $is_event,
        int $is_abonements_allow_all
    )
    {
        $this->dance_group_id = $dance_group_id;
        $this->name = $name;
        $this->teacher_id = $teacher_id;
        $this->description = $description;
        $this->status = $status;
        $this->status_for_app = $status_for_app;
        $this->status_of_creative = $status_of_creative;
        $this->branch_id = $branch_id;
        $this->is_active_reservation = $is_active_reservation;
        $this->is_event = $is_event;
        $this->is_abonements_allow_all = $is_abonements_allow_all;
    }

    

    /**
     * Get the value of dance_group_id
     */ 
    public function getDance_group_id()
    {
        return $this->dance_group_id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of teacher_id
     */ 
    public function getTeacher_id(): int
    {
        return $this->teacher_id;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Get the value of status_for_app
     */ 
    public function getStatus_for_app(): int
    {
        return $this->status_for_app;
    }

    /**
     * Get the value of status_of_creative
     */ 
    public function getStatus_of_creative(): int
    {
        return $this->status_of_creative;
    }

    /**
     * Get the value of branch_id
     */ 
    public function getBranch_id(): int
    {
        return $this->branch_id;
    }

    /**
     * Get the value of is_active_reservation
     */ 
    public function getIs_active_reservation(): int
    {
        return $this->is_active_reservation;
    }

    /**
     * Get the value of is_event
     */ 
    public function getIs_event(): int
    {
        return $this->is_event;
    }

    /**
     * Get the value of is_abonements_allow_all
     */ 
    public function getIs_abonements_allow_all(): int
    {
        return $this->is_abonements_allow_all;
    }
}