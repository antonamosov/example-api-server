<?php

namespace App\Services;

interface UserServiceInterface
{
    public function updateOrCreate(array $details);
}
