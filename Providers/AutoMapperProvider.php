<?php

namespace App\Providers;

use App\Mapper\AutoMapper\PropertyAccessor;
use App\Mapper\MappingFactoryInterface;
use App\Mapper\UserMappingFactory;
use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\NameConverter\NamingConvention\CamelCaseNamingConvention;
use AutoMapperPlus\NameConverter\NamingConvention\SnakeCaseNamingConvention;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class AutoMapperProvider
 *
 * @package App\Providers
 */
class AutoMapperProvider extends ServiceProvider
{
    const FACTORY_TAG = 'mapper.factories';

    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * On boot bindings
     */
    public function boot()
    {
        $this->registerFactories();

        $this->app->singleton(
            AutoMapper::class, function (Application $container) {
            $config = $container->make(AutoMapperConfig::class);

            return new AutoMapper($config);
        });

        $this->app->bind(AutoMapperInterface::class, AutoMapper::class);

        $this->app->singleton(
            AutoMapperConfig::class, function (Application $container) {
            $config  = new AutoMapperConfig();
            $options = $config->getOptions();
            $options->setSourceMemberNamingConvention(new SnakeCaseNamingConvention());
            $options->setDestinationMemberNamingConvention(new CamelCaseNamingConvention());
            $options->setPropertyAccessor(new PropertyAccessor());
            $options->skipConstructor();

            $factories = $container->tagged(static::FACTORY_TAG);

            foreach ($factories as $factory) {
                if (!$factory instanceof MappingFactoryInterface) {
                    throw new \RuntimeException(
                        sprintf('Only %s instances allowed under tag %s', MappingFactoryInterface::class, static::FACTORY_TAG)
                    );
                }

                $factory->registerMapping($config);
            }

            return $config;
        });

        $this->app->bind(AutoMapperConfigInterface::class, AutoMapperConfig::class);
    }

    /**
     * Registers mapping factories
     */
    protected function registerFactories()
    {
        $this->app->tag(
            [
                UserMappingFactory::class,
            ],
            static::FACTORY_TAG
        );
    }
}
