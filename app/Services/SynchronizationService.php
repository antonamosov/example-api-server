<?php

namespace App\Services;

use App\Exceptions\SynchronizationFailedException;
use Illuminate\Support\Facades\Http;

class SynchronizationService implements SynchronizationServiceInterface
{
    const SYNC_URL = 'https://example.com/';

    public function syncUser(array $details): void
    {
        $response = Http::put(self::SYNC_URL.'users', $details);

        if ($response->failed()) {
            throw new SynchronizationFailedException("The user {$details['email']} has not ben synchronized.");
        }
    }
}
