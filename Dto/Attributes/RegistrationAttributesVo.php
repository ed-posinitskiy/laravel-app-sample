<?php

namespace App\Dto\Attributes;

/**
 * Class RegistrationAttributesVo
 *
 * @package App\Dto\Attributes
 */
class RegistrationAttributesVo extends AbstractAttributesObject
{

    public function getPassword(): string
    {
        return $this->get('password', '');
    }

    /**
     * Returns available attribute names
     *
     * @return array
     */
    public static function attributes(): array
    {
        return [
            'email',
            'username',
            'password',
        ];
    }
}
