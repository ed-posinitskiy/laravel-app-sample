<?php
/**
 * File contains Class Menu
 *
 * @since  16.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Twig\Extension\App;

use Twig_SimpleFunction;
use Lavary\Menu\Item as LavaryMenu;

/**
 * Class Menu
 *
 * @package App\Twig\Extension\App
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class Menu extends \Twig_Extension
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'App_Extension_App_Menu';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('menu', [$this, 'getMenu']),
        ];
    }

    /**
     * @param string $name
     *
     * @return LavaryMenu|null
     */
    public function getMenu(string $name)
    {
        return \Menu::get($name);
    }
}
