<?php

namespace App\Http\Resource\Extractor\Strategy;

use DateTime;
use InvalidArgumentException;

/**
 * Class DateTimeStrategy
 *
 * @package App\Http\Resource\Extractor\Strategy
 */
class DateTimeStrategy implements StrategyInterface
{
    protected $format;

    /**
     * DateTimeStrategy constructor.
     *
     * @param string $format
     */
    public function __construct(string $format = DateTime::ISO8601)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @param DateTime $value
     * @param object   $context OPTIONAL
     *
     * @return string
     */
    public function extract($value, $context = null)
    {
        if (!$value instanceof DateTime) {
            throw new InvalidArgumentException(
                sprintf(
                    'Instance of [%s] expected, got [%s]',
                    DateTime::class,
                    is_object($value) ? get_class($value) : gettype($value)
                )
            );
        }

        return $value->format($this->format);
    }
}
