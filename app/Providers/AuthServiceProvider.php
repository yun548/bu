<?php

namespace App\Providers;

use App\Models\Document;
use App\Policies\DocumentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [// 'App\Models\Model' => 'App\Policies\ModelPolicy',
                           Document::class => DocumentPolicy::class,
    ];
    
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
