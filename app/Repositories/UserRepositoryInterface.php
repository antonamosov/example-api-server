<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function updateOrCreate(array $params);
}
