<?php

namespace App\Module\Behaviour;

use View;

/**
 * Trait MakesView
 *
 * @package App\Module\Controller
 */
trait MakesView
{
    /**
     * @param       $path
     * @param array $data
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function makeView($path, $data = [])
    {
        if (!property_exists($this, 'moduleAlias')) {
            throw new \RuntimeException(
                sprintf('Trait %s can be used only with %s trait', __TRAIT__, AwareOfModuleAlias::class)
            );
        }

        $viewPath = sprintf('%s::%s', $this->moduleAlias, $path);

        return View::make($viewPath, $data);
    }
}
