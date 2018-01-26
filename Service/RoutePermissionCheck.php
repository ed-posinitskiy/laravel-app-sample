<?php
/**
 * File contains Class RoutePermissionCheck
 *
 * @since  16.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Service;

use App\Model\User;
use Illuminate\Routing\Route;

/**
 * Class RoutePermissionCheck
 *
 * @package App\Service
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class RoutePermissionCheck
{

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * RoutePermissionCheck constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param User  $user
     * @param Route $route
     *
     * @return bool
     */
    public function isGranted(User $user, Route $route): bool
    {
        $allowedPermissions = null;

        foreach ($this->rules as $routeRule => $permissions) {
            if (fnmatch($routeRule, $route->getName(), FNM_CASEFOLD | FNM_NOESCAPE)) {
                $allowedPermissions = (array)$permissions;
                break;
            }
        }

        if (empty($allowedPermissions)) {
            return true;
        }

        if (in_array('*', $allowedPermissions)) {
            return true;
        }

        return $user->hasPermission($allowedPermissions);
    }
}
