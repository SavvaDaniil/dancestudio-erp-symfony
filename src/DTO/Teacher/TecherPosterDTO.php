<?php

namespace App\DTO\Teacher;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TecherPosterDTO {

    public int $teacher_id;
    public ?UploadedFile $poster_file;
    
}