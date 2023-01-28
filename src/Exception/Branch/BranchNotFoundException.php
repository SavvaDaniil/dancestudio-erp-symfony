<?php

namespace App\Exception\Branch;

use RuntimeException;

class BranchNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("branch not found");
    }
}