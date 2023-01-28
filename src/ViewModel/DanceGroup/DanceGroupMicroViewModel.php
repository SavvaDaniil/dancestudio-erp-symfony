<?php

namespace App\ViewModel\DanceGroup;

class DanceGroupMicroViewModel {
    
    public int $id;
    public ?string $name;

    public function __construct(int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

}