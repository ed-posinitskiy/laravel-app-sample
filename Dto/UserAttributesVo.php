<?php

namespace App\Dto;

use App\Dto\Attributes\AbstractAttributesObject;

/**
 * Class UserAttributesVo
 *
 * @package App\Dto
 *
 * @method withUsername(string $username)
 * @method withEmail(string $email)
 */
class UserAttributesVo extends AbstractAttributesObject
{
    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->get('email');
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->get('username');
    }

    /**
     * Returns available attribute names
     *
     * @return array
     */
    public static function attributes(): array
    {
        return [
            'username',
            'email',
        ];
    }
}
