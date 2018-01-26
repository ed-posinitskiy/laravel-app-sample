<?php

namespace App\Module;

use App\Module\Feature\AliasProviderInterface;
use App\Module\Feature\ConfigProviderInterface;
use App\Module\Feature\RoutesProviderInterface;
use App\Module\Feature\ViewsProviderInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;
use RuntimeException;

/**
 * Class ModuleManager
 *
 * @package App\Module
 */
class ModuleManager extends ServiceProvider
{
    /**
     * @var string[] Module names against module class names
     */
    protected $modules = [];

    /**
     * @var ServiceProvider[] Instantiated modules
     */
    protected $providers = [];

    /**
     * @var string[] Module aliases
     */
    protected $aliases = [];

    /**
     * @var bool
     */
    protected $booted = false;

    /**
     * @return void
     */
    public function register()
    {
        $this->collect();

        foreach ($this->modules as $key => $module) {
            $provider              = $this->app->register($module);
            $alias                 = $this->resolveAlias($provider, $module);
            $this->providers[$key] = $provider;

            $this->resolveConfig($alias, $provider);
        }
    }

    /**
     * @return void
     */
    public function boot()
    {
        foreach ($this->providers as $module => $provider) {
            $alias = $this->resolveAlias($provider, $module);

            $this->resolveViews($alias, $provider);
            $this->resolveRoutes($module, $provider);
        }
    }

    /**
     * @return void
     */
    protected function collect()
    {
        if ($this->booted) {
            return;
        }

        $list = $this->getConfig('modules', []);

        foreach ($list as $item) {
            $moduleClass = sprintf('%s\\Module', $item);

            if (!class_exists($moduleClass)) {
                throw new RuntimeException(
                    sprintf(
                        'Module %s could not be loaded, class %s does not exist',
                        $item,
                        $moduleClass
                    )
                );
            }

            $this->modules[$item] = $moduleClass;
        }

        $this->booted = true;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function getConfig($key, $default = null)
    {
        return $this->app['config']->get(sprintf('modules.%s', $key), $default);
    }

    /**
     * @param string                  $alias
     * @param ConfigProviderInterface $provider
     */
    protected function resolveConfig($alias, $provider)
    {
        if (!$provider instanceof ConfigProviderInterface) {
            return;
        }

        $this->mergeConfigFrom($provider->getConfigPath(), $alias);
    }

    /**
     * @param string                 $alias
     * @param ViewsProviderInterface $provider
     */
    protected function resolveViews($alias, $provider)
    {
        if (!$provider instanceof ViewsProviderInterface) {
            return;
        }

        $this->loadViewsFrom($provider->getViewsPath(), $alias);
    }

    /**
     * @param string                  $module
     * @param RoutesProviderInterface $provider
     */
    protected function resolveRoutes($module, $provider)
    {
        if (!$provider instanceof RoutesProviderInterface) {
            return;
        }

        Route::middleware('web')->group($provider->getRoutesPath());
    }

    /**
     * @param AliasProviderInterface $provider
     * @param string                 $module
     *
     * @return string
     */
    protected function resolveAlias($provider, $module)
    {
        if (isset($this->aliases[$module])) {
            return $this->aliases[$module];
        }

        $alias = $provider instanceof AliasProviderInterface ? $provider->getAlias() : Str::slug($module, '.');

        return $this->modules[$module] = $alias;
    }
}
