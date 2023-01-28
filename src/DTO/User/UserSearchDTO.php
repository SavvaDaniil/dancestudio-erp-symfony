<?php

namespace App\DTO\User;

class UserSearchDTO {

    private int $page;
    private ?string $query_string;
    private bool $is_need_count;

    public function __construct(int $page, ?string $query_string, bool $is_need_count){
        $this->page = $page;
        $this->query_string = $query_string;
        $this->is_need_count = $is_need_count;
    }

    /**
     * Get the value of page
     */ 
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the value of query_string
     */ 
    public function getQuery_string()
    {
        return $this->query_string;
    }

    /**
     * Get the value of is_need_count
     */ 
    public function getIs_need_count()
    {
        return $this->is_need_count;
    }
}