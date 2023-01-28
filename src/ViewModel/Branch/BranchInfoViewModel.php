<?php


namespace App\ViewModel\Branch;

class BranchInfoViewModel extends BranchLiteViewModel {

    public ?string $description;

    public function __construct(int $id, ?string $name, ?string $coordinates, ?string $description){
        parent::__construct($id, $name, $coordinates);
        
        $this->description = $description;
    }

}