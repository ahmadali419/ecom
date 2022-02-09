<?php

namespace App\Providers;

use App\Models\StoreSetting;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $domain = getDomainSlug();
        // $storeSetting = StoreSetting::where('slug',$domain->slug)->first();
        // View::share('storeSetting', $storeSetting);
    }
}
