<?php

namespace App\Hydrator;

/**
 * Trait ExtractsDto
 *
 * @package App\Hydrator
 */
trait ExtractsDto
{
    /**
     * @return array
     */
    public function toArray()
    {
        $public = (array)method_exists($this, 'getPublicProperties')
            ? $this->getPublicProperties()
            : ['*'];

        $isWildcard = $public === ['*'];
        $out        = [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!($isWildcard || in_array($key, $public))) {
                continue;
            }

            $getter = 'get' . ucfirst($key);

            if (method_exists($this, $getter)) {
                $out[$key] = call_user_func([$this, $getter]);

                continue;
            }

            $booleanGetter = 'is' . ucfirst($key);

            if (method_exists($this, $booleanGetter)) {
                $out[$key] = call_user_func([$this, $booleanGetter]);

                continue;
            }

            $out[$key] = $value;
        }

        return $out;
    }
}
