<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use App\Setting;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($locale = Setting::getSiteLocale())
        {
            $locale_dirs = array_filter(glob('../resources/lang/*'), 'is_dir');
            if(in_array($locale, $locale_dirs))
            {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}
