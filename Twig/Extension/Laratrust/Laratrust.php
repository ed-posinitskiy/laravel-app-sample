<?php
/**
 * File contains Class Laratrust
 *
 * @since  17.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Twig\Extension\Laratrust;

use Laratrust as LaratrustFacade;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class Laratrust
 *
 * @package Twig\Extension\Laratrust
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class Laratrust extends Twig_Extension
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'App_Extension_App_Laratrust';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('can', [$this, 'can']),
            new Twig_SimpleFunction('hasRole', [$this, 'hasRole']),
            new Twig_SimpleFunction('canAndOwns', [$this, 'canAndOwns']),
            new Twig_SimpleFunction('hasRoleAndOwns', [$this, 'hasRoleAndOwns']),
        ];
    }

    /**
     * @param string $permission
     * @param null   $team
     * @param bool   $requireAll
     *
     * @return bool
     */
    public function can($permission, $team = null, $requireAll = false)
    {
        return LaratrustFacade::can($permission, $team, $requireAll);
    }

    /**
     * @param string $role
     * @param null   $team
     * @param bool   $requireAll
     *
     * @return bool
     */
    public function hasRole($role, $team = null, $requireAll = false)
    {
        return LaratrustFacade::hasRole($role, $team, $requireAll);
    }

    /**
     * @param string $permission
     * @param object $thing
     * @param array  $options
     *
     * @return bool
     */
    public function canAndOwns($permission, $thing, $options = [])
    {
        return LaratrustFacade::canAndOwns($permission, $thing, $options);
    }

    /**
     * @param string $role
     * @param object $thing
     * @param array  $options
     *
     * @return bool
     */
    public function hasRoleAndOwns($role, $thing, $options = [])
    {
        return LaratrustFacade::hasRoleAndOwns($role, $thing, $options);
    }
}
