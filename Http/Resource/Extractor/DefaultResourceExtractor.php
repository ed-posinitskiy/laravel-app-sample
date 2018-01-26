<?php

namespace App\Http\Resource\Extractor;

use App\Http\Resource\Extractor\Strategy\DateTimeStrategy;
use App\Http\Resource\Extractor\Strategy\StrategyInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class DefaultResourceExtractor
 *
 * @package App\Http\Resource
 */
class DefaultResourceExtractor implements PropertiesExtractorInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * @var array
     */
    protected $props = [];

    /**
     * @var array
     */
    protected $dates = [];

    /**
     * @var StrategyInterface[]
     */
    protected $strategies = [];

    /**
     * @param object $object
     */
    public function extract($object): void
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Input value MUST be an object');
        }

        $this->model = $object;
    }

    /**
     * Defines properties to extract from object
     *
     * @param array $properties
     */
    public function properties(array $properties): void
    {
        $this->props = $properties;
    }

    /**
     * Extracts given (via extract() method) object to array
     *
     * @return array
     */
    public function toArray(): array
    {
        if (empty($this->model) || !is_object($this->model)) {
            throw new RuntimeException(
                'Extract model is not defined. Set it up via [extract()] method'
            );
        }

        $data  = [];
        $props = array_unique(array_merge($this->props, $this->dates));

        foreach ($props as $property) {
            $getterPrefixes = [
                'get',
                'is',
            ];

            foreach ($getterPrefixes as $prefix) {
                $getter = $prefix . ucfirst($property);

                if (!method_exists($this->model, $getter)) {
                    continue;
                }

                $value = $this->model->{$getter}();

                if ($this->hasStrategy($property)) {
                    $value = $this->strategies[$property]->extract($value, $this->model);
                }

                $data[$property] = $value;

                break;
            }
        }

        return $data;
    }

    /**
     * @param string            $prop
     * @param StrategyInterface $strategy
     */
    public function addStrategy(string $prop, StrategyInterface $strategy): void
    {
        $this->strategies[$prop] = $strategy;
    }

    /**
     * @param string $prop
     *
     * @return bool
     */
    public function hasStrategy(string $prop): bool
    {
        return isset($this->strategies[$prop]);
    }

    /**
     * @param string $prop
     */
    public function removeStrategy(string $prop): void
    {
        if ($this->hasStrategy($prop)) {
            unset($this->strategies[$prop]);
        }
    }

    /**
     * @param array $dateProperties
     */
    public function withDates(array $dateProperties): void
    {
        foreach ($dateProperties as $prop) {
            if (in_array($prop, $this->dates)) {
                continue;
            }

            array_push($this->dates, $prop);

            $this->strategies[$prop] = new DateTimeStrategy();
        }
    }
}
