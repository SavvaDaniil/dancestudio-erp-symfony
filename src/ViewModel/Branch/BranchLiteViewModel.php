<?php

namespace App\ViewModel\Branch;

class BranchLiteViewModel extends BranchMicroViewModel {

    public ?string $coordinates;

    public function __construct(int $id, ?string $name, ?string $coordinates){
        parent::__construct($id, $name);
        $this->coordinates = $coordinates;
    }
    
}