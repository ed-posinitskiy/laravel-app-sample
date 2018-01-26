<?php
/**
 * File contains Class CheckPermissions
 *
 * @since  16.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Http\Middleware;

use App\Service\RoutePermissionCheck;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

/**
 * Class CheckPermissions
 *
 * @package App\Http\Middleware
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class CheckPermissions
{
    /**
     * @var RoutePermissionCheck
     */
    protected $permissionService;

    /**
     * CheckPermissions constructor.
     *
     * @param RoutePermissionCheck $permissionService
     */
    public function __construct(RoutePermissionCheck $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @param Request      $request
     * @param Closure      $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest() || $this->permissionService->isGranted(Auth::user(), $request->route())) {
            return $next($request);
        }

        return $request->ajax() ? abort(403, 'Access denied') : redirect()->route('home');
    }
}
