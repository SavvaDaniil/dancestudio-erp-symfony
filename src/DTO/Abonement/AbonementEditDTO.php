<?php


namespace App\DTO\Abonement;

class AbonementEditDTO {
    
    private int $abonement_id;
    private ?string $name;
    private int $days;
    private int $price;
    private int $visits;
    private int $status_of_visible;
    private int $status_for_app;
    private int $is_private;
    
    public function __construct(
        int $abonement_id,
        ?string $name,
        int $days,
        int $price,
        int $visits,
        int $status_of_visible,
        int $status_for_app,
        int $is_private
    ){
        $this->abonement_id = $abonement_id;
        $this->name = $name;
        $this->days = $days;
        $this->price = $price;
        $this->visits = $visits;
        $this->status_of_visible = $status_of_visible;
        $this->status_for_app = $status_for_app;
        $this->is_private = $is_private;
    }
    


    /**
     * Get the value of abonement_id
     */ 
    public function getAbonement_id()
    {
        return $this->abonement_id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of days
     */ 
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of visits
     */ 
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * Get the value of status_of_visible
     */ 
    public function getStatus_of_visible()
    {
        return $this->status_of_visible;
    }

    /**
     * Get the value of status_for_app
     */ 
    public function getStatus_for_app()
    {
        return $this->status_for_app;
    }

    /**
     * Get the value of is_private
     */ 
    public function getIs_private()
    {
        return $this->is_private;
    }
}