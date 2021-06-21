<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\SynchronizationService;
use App\Services\SynchronizationServiceInterface;
use App\Services\UserService;
use App\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserServiceInterface::class => UserService::class,
        UserRepositoryInterface::class => UserRepository::class,
        SynchronizationServiceInterface::class => SynchronizationService::class,
    ];

    public function register()
    {
        //
    }

    public function boot()
    {
        //
    }
}
