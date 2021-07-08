<?php

namespace App\Providers;

use App\Models\Section;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Spatie\OpeningHours\OpeningHours;

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
        Paginator::useBootstrap();
        View::composer('includes.hero', function ($view) {
            $view->with([
                'header' => Section::where('name', 'header')->first(),
            ]);
        });
        View::composer('includes.about-section', function ($view) {
            $view->with([
                'about' => Section::where('name', 'about')->first(),

            ]);
        });
        View::composer('includes.hero-meals', function ($view) {
            $nextOpen = OpeningHours::create(config('schedule.openingHours'))->nextOpen(Carbon::now())->translatedFormat('l H:i');
            $view->with([
                'nextOpen' => $nextOpen,
                "forcedClose" => config('schedule.forcedClose')
            ]);
        });
        View::composer('includes.footer', function ($view) {
            $openingHours = OpeningHours::create(config('schedule.openingHours'))->forWeekConsecutiveDays();
            // dd($openingHours);
            $view->with([
                'openingHours' => $openingHours
            ]);
        });
    }
}
