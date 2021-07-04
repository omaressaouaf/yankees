<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\OpeningHours\OpeningHours;


class CheckSchedule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $openingHours = OpeningHours::create(array_merge(['overflow' => true],  config('schedule.openingHours')));
        $forecedClose = config('schedule.forcedClose');
        if ($openingHours->isClosed() || $forecedClose) {
            return redirect('/');
        }
        return $next($request);
    }
}
