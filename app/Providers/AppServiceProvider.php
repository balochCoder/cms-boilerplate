<?php

namespace App\Providers;

use App\Models\WebSetting;
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
        $favicon = WebSetting::where('key', 'favicon')->first();
        $logo = WebSetting::where('key', 'logo')->first();


        View::share(
            [
                'favicon' => json_decode($favicon->data),
                'logo' => json_decode($logo->data)
            ]
        );
    }
}
