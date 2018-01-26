<?php
/**
 * File contains Class JsonSerializableTrait
 *
 * @since  30.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Dto;

/**
 * Class JsonSerializableTrait
 *
 * @package App\Dto
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
trait JsonSerializableTrait
{
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $items = [];
        foreach ($this->getSerializable() as $property) {
            $getter = sprintf('get%s', ucfirst($property));
            if (method_exists($this, $getter)) {
                $items[$property] = call_user_func([$this, $getter]);
                continue;
            }
            $isGetter = sprintf('is%s', ucfirst($property));
            if (method_exists($this, $isGetter)) {
                $items[$property] = call_user_func([$this, $isGetter]);
            }

        }
        return $items;
    }

    /**
     * @return array
     */
    protected function getSerializable(): array
    {
        if (!isset($this->serializable) || !is_array($this->serializable)) {
            return [];
        }
        return $this->serializable;
    }
}