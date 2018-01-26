<?php

namespace App\Mapper;

use AutoMapperPlus\Configuration\AutoMapperConfig;

/**
 * Interface MappingFactoryInterface
 *
 * @package App\Mapper
 */
interface MappingFactoryInterface
{
    public function registerMapping(AutoMapperConfig $config);
}
