<?php

namespace App\Providers;

use App\Module\Behaviour\ModuleAliasAwareInstance;
use App\Module\Feature\AliasProviderInterface;
use App\Module\Helper\ModuleNameResolver;
use Config;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleAliasServiceProvider
 *
 * @package App\Providers
 */
class ModuleAliasServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(
            ModuleNameResolver::class, function () {
            return new ModuleNameResolver(Config::get('modules.modules'));
        });

        $this->app->resolving(
            ModuleAliasAwareInstance::class,
            function (ModuleAliasAwareInstance $object, Application $app) {
                /** @var ModuleNameResolver $resolver */
                $resolver = $app->make(ModuleNameResolver::class);
                $module   = $resolver->resolve(get_class($object));

                if (!$module) {
                    return;
                }

                $moduleClass = sprintf('%s\\%s', $module, 'Module');

                try {
                    $moduleInstance = $app->resolveProvider($moduleClass);
                } catch (\Throwable $ex) {
                    $moduleInstance = new $moduleClass($app);
                }

                if (!$moduleInstance instanceof AliasProviderInterface) {
                    throw new \RuntimeException(
                        sprintf('Module %s MUST provide ALIAS', $moduleClass)
                    );
                }

                $object->setModuleAlias($moduleInstance->getAlias());
            }
        );
    }
}
