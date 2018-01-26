<?php

namespace App\Http\Resource\Helper;

/**
 * Trait CrudResourceTrait
 *
 * @package App\Http\Resource\Helper
 */
trait CrudResourceTrait
{
    public function isUpdatedResource(): void
    {
        $this->withMeta('crudMode', 'updated');
    }

    public function isCreatedResource(): void
    {
        $this->withMeta('crudMode', 'created');
    }

    public function isDeletedResource(): void
    {
        $this->withMeta('crudMode', 'deleted');
    }
}
