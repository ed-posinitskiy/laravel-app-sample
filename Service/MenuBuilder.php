<?php
/**
 * File contains Class MenuBuilder
 *
 * @since  16.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Service;

use App\Model\User;
use Illuminate\Routing\Route;
use Lavary\Menu\Builder;
use Lavary\Menu\Item;
use Lavary\Menu\Menu;

/**
 * Class MenuBuilder
 *
 * @package App\Service
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class MenuBuilder
{
    /**
     * @var RoutePermissionCheck
     */
    protected $permissionService;

    /**
     * MenuBuilder constructor.
     *
     * @param RoutePermissionCheck $permissionService
     */
    public function __construct(RoutePermissionCheck $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @param string $name
     * @param User   $user
     *
     * @return Menu
     */
    public function build(string $name, User $user)
    {
        $config = $this->getConfig($name);
        $menu   = \Menu::make(
            $name,
            function (Builder $menu) use ($config) {
                if (!empty($config['items']) && is_array($config['items'])) {
                    $this->addItem($menu, $config['items']);
                }
            }
        )->filter(
            function (Item $item) use ($user) {
                $route = \Route::getRoutes()->getByName($item->data('routename'));
                if (!$route instanceof Route) {
                    return true;
                }

                return $this->permissionService->isGranted($user, $route);
            }
        )->filter(
            function (Item $item) {
                if (!$item->data('has_children')) {
                    return true;
                }

                if (empty($item->data('routename')) && !$item->hasChildren()) {
                    return false;
                }

                return true;
            }
        );

        return $menu;
    }

    /**
     * @param mixed $menu
     * @param array $config
     */
    public function addItem($menu, array $config)
    {
        foreach ($config as $key => $item) {
            $options = !empty($item['attributes']) && is_array($item['attributes']) ? $item['attributes'] : [];
            if (!empty($item['route'])) {
                $options['route'] = $item['route'];
            }

            $menuItem = $menu->add($item['label'], $options);
            if (!empty($item['route'])) {
                $menuItem->data('routename', $item['route']);
            }

            if (!empty($item['items']) && is_array($item['items'])) {
                $menuItem->data('has_children', true);
                $this->addItem($menuItem, $item['items']);
            }
        }
    }

    /**
     * @param $key
     *
     * @return array
     */
    protected function getConfig($key): array
    {
        $config = config('menu');

        return empty($config[$key]) || !is_array($config[$key]) ? [] : $config[$key];
    }
}
