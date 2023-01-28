<?php

namespace App\ViewModel\User;

class UserSearchPreviewViewModel {

    public int $id;
    public ?string $secondname;
    public ?string $firstname;
    public ?string $date_of_last_visit;
    public ?string $date_of_add;

    public ?string $telephone;
    public ?string $card;

    public function __construct(
        int $id,
        ?string $secondname,
        ?string $firstname,
        ?string $date_of_last_visit,
        ?string $date_of_add,
        ?string $telephone,
        ?string $card
    )
    {
        $this->id = $id;
        $this->secondname = $secondname;
        $this->firstname = $firstname;
        $this->date_of_last_visit = $date_of_last_visit;
        $this->date_of_add = $date_of_add;
        $this->telephone = $telephone;
        $this->card = $card;
    }

}