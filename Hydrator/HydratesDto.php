<?php

namespace App\Hydrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Trait HydratesDto
 *
 * @package App\Hydrator
 */
trait HydratesDto
{
    /**
     * @param Model $model
     *
     * @return $this
     */
    public function fromModel(Model $model)
    {
        $attributes = collect($model->getAttributes())->map(
            function ($value, $key) use ($model) {
                return $model->getAttributeValue($key);
            });

        return $this->fromArray($attributes->toArray());
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function fromArray(array $attributes)
    {
        $fillable = (array)method_exists($this, 'getFillableProperties')
            ? $this->getFillableProperties()
            : ['*'];

        $isWildcard = $fillable === ['*'];

        foreach ($attributes as $key => $value) {
            $normalizedKey = Str::camel($key);

            if (!($isWildcard || !empty(Arr::only(array_flip($fillable), [$key, $normalizedKey])))) {
                continue;
            }

            $setter = 'set' . ucfirst($normalizedKey);

            if (method_exists($this, $setter)) {
                call_user_func([$this, $setter], $value);

                continue;
            }

            if (property_exists($this, $normalizedKey)) {
                $this->{$normalizedKey} = $value;
            } elseif (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}
