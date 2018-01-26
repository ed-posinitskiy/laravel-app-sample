<?php

namespace App\Mapper\AutoMapper\Operation;

use AutoMapperPlus\MappingOperation\Implementations\MapTo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MapToRelation
 *
 * @package App\Mapper\AutoMapper\Operation
 */
class MapToRelation extends MapTo
{
    protected function canMapProperty(string $propertyName, $source): bool
    {
        if (!$source instanceof Model) {
            return false;
        }

        return $source->relationLoaded($propertyName);
    }
}
