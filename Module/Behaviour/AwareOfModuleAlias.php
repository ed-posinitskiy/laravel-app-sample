<?php

namespace App\Module\Behaviour;

/**
 * Trait AwareOfModuleAlias
 *
 * @package App\Module\Controller
 */
trait AwareOfModuleAlias
{
    /**
     * @var string
     */
    protected $moduleAlias;

    /**
     * @param string $alias
     *
     * @return void
     */
    public function setModuleAlias(string $alias)
    {
        $this->moduleAlias = $alias;
    }
}
