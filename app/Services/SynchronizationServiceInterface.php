<?php

namespace App\Services;

interface SynchronizationServiceInterface
{
    public function syncUser(array $details): void;
}
