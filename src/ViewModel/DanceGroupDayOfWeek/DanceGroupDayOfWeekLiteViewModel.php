<?php

namespace App\ViewModel\DanceGroupDayOfWeek;

class DanceGroupDayOfWeekLiteViewModel {

    public int $id;
    public int $dance_group_id;
    public int $day_of_week;
    public int $status;
    public ?string $time_from;
    public ?string $time_to;
    public int $is_event;
    public ?string $date_of_event;

    public function __construct(
        int $id,
        int $dance_group_id,
        int $day_of_week,
        int $status,
        ?string $time_from,
        ?string $time_to,
        int $is_event,
        ?string $date_of_event
    )
    {
        $this->id = $id;
        $this->dance_group_id = $dance_group_id;
        $this->day_of_week = $day_of_week;
        $this->status = $status;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
        $this->is_event = $is_event;
        $this->date_of_event = $date_of_event;
    }

}