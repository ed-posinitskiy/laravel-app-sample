<?php

namespace App\Dto;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait StoresOriginalModel
 *
 * @package App\Dto
 */
trait StoresOriginalModel
{
    /**
     * @var Model
     */
    protected $originalModel;

    /**
     * @return Model|null
     */
    public function getOriginal()
    {
        return $this->originalModel;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return isset($this->originalModel);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        if (!isset($this->originalModel)) {
            throw new BadMethodCallException(
                '%s::id is not reachable due to Original Model missing',
                get_class($this)
            );
        }

        return $this->originalModel->id;
    }

    /**
     * @param Model $model
     * @param bool  $hydrate
     *
     * @return $this
     */
    public function storeOriginal(Model $model, $hydrate = true)
    {
        $this->originalModel = $model;

        if (true === $hydrate && method_exists($this, 'fromModel')) {
            $this->fromModel($model);
        }

        return $this;
    }
}
