<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateOrCreate(array $params): User
    {
        $email = $params['email'];
        $user = $this->user->whereEmail($email)->first();

        if ($user) {
            $user->update($params);
        } else {
            $user = $this->user->create($params);
        }

        return $user;
    }
}
