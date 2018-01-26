<?php

namespace App\Twig\Extension\Filter;

use TwigBridge\Extension\Loader\Loader;

/**
 * Class DateFormat
 *
 * @package App\Twig\Extension\Filter
 */
class DateFormat extends Loader
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('date_format', [$this, 'format']),
        ];
    }

    /**
     * @param \DateTime $date
     * @param string    $mode
     *
     * @return string
     */
    public function format(\DateTime $date, $mode = 'date')
    {
        $modes = $this->config->get('date.format.render');

        if (!array_key_exists($mode, $modes)) {
            throw new \InvalidArgumentException(
                sprintf('Mode %s is not supported, use one of [%s]', $mode, implode(', ', array_keys($modes)))
            );
        }

        return $date->format($modes[$mode]);
    }
}
