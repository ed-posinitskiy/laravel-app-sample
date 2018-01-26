<?php

namespace App\Mapper;

use App\Dto\UserEntityTo;
use App\Model\User;
use AutoMapperPlus\Configuration\AutoMapperConfig;

/**
 * Class UserMappingFactory
 *
 * @package App\Mapper
 */
class UserMappingFactory implements MappingFactoryInterface
{

    public function registerMapping(AutoMapperConfig $config)
    {
        $config->registerMapping(User::class, UserEntityTo::class);
    }
}
