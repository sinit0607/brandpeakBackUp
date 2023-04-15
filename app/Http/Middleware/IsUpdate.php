<?php

namespace App\Http\Middleware;

use Closure;

class IsUpdate
{
    public function handle($request, Closure $next)
    {
        if (!$this->updateVersion()) {
            return redirect("update-version");
        }

        return $next($request);
    }

    public function updateVersion()
    {
        return (file_exists(storage_path('installed')) && file_get_contents(storage_path('installed')) == "brand_kit6");
    }
}
