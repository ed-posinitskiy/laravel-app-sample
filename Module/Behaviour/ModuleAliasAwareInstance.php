<?php

namespace App\Module\Behaviour;

/**
 * Interface ModuleAliasAwareInstance
 *
 * @package App\Module\Controller
 */
interface ModuleAliasAwareInstance
{
    /**
     * @param string $alias
     *
     * @return void
     */
    public function setModuleAlias(string $alias);
}
