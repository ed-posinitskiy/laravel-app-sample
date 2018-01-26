<?php

namespace App\Http\Resource\Extractor\Strategy;

/**
 * Interface StrategyInterface
 *
 * @package App\Http\Resource\Extractor\Strategy
 */
interface StrategyInterface
{
    /**
     * @param mixed  $value
     * @param object $context OPTIONAL
     *
     * @return mixed
     */
    public function extract($value, $context = null);
}
