<?php

namespace App\Twig\Extension\Laravel;

use Twig_SimpleFunction;
use TwigBridge\Extension\Laravel\Session as BaseExtension;

/**
 * Class Session
 *
 * @package App\Twig\Extension\Laravel
 */
class Session extends BaseExtension
{
    public function getName()
    {
        return 'App_Extension_Laravel_Session';
    }

    public function getFunctions()
    {
        return array_merge(
            parent::getFunctions(),
            [
                new Twig_SimpleFunction('session_forget', [$this->session, 'forget']),
            ]
        );
    }

}
