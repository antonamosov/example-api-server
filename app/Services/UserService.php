<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Connection;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $users;
    private SynchronizationServiceInterface $synchronizationService;
    private Connection $connection;

    public function __construct(
        UserRepositoryInterface $users,
        SynchronizationServiceInterface $synchronizationService,
        Connection $connection,
    ) {
        $this->users = $users;
        $this->synchronizationService = $synchronizationService;
        $this->connection = $connection;
    }

    public function updateOrCreate(array $details)
    {
        $this->connection->transaction(function () use ($details) {
            $user = $this->users->updateOrCreate($details);
            $this->synchronizationService->syncUser($user->toArray());
        });
    }
}
