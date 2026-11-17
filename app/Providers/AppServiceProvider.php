<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\ModuleSetting;
use App\Policies\ContactPolicy;
use App\Policies\DealPolicy;
use App\Policies\ModuleSettingPolicy;
use App\Services\ModuleManager;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ModuleManager::class);
    }

    public function boot(): void
    {
        Gate::policy(Deal::class, DealPolicy::class);
        Gate::policy(Contact::class, ContactPolicy::class);
        Gate::policy(ModuleSetting::class, ModuleSettingPolicy::class);
    }
}