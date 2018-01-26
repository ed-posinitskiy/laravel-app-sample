<?php

namespace App\Module;

use App\Module\Feature\AliasProviderInterface;
use App\Module\Feature\ProvidesNamespacedPath;
use Illuminate\Support\ServiceProvider;

/**
 * Class AbstractModule
 *
 * @package App\Module
 */
abstract class AbstractModule extends ServiceProvider implements AliasProviderInterface
{
    use ProvidesNamespacedPath;

    /**
     * Registers module services
     */
    public function register()
    {

    }

    /**
     * Bootstraps module dependencies
     */
    public function boot()
    {

    }
}
