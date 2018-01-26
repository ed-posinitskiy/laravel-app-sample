<?php

namespace App\Http\Middleware;

use App\Service\MenuBuilder;
use Closure;
use Illuminate\Support\Facades\Auth;

class GenerateMenus
{
    /**
     * @var MenuBuilder
     */
    protected $menuBuilder;

    /**
     * GenerateMenus constructor.
     *
     * @param MenuBuilder $menuBuilder
     */
    public function __construct(MenuBuilder $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            return $next($request);
        }
        $this->menuBuilder->build('top-menu', Auth::user());

        return $next($request);
    }
}
