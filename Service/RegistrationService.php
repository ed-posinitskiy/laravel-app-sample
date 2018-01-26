<?php

namespace App\Service;

use App\Dto\Attributes\RegistrationAttributesVo;
use App\Dto\Transformer\UserEntityToTransformer;
use App\Dto\UserEntityTo;
use App\Model\User;
use Illuminate\Auth\Events\Registered;

/**
 * Class RegistrationService
 *
 * @package App\Service
 */
class RegistrationService
{
    /**
     * @var UserEntityToTransformer
     */
    protected $transformer;

    /**
     * RegistrationService constructor.
     *
     * @param UserEntityToTransformer $transformer
     */
    public function __construct(UserEntityToTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param RegistrationAttributesVo $attributes
     *
     * @return UserEntityTo
     */
    public function register(RegistrationAttributesVo $attributes)
    {
        $data = array_merge(
            $attributes->toArray(),
            ['password' => bcrypt($attributes->getPassword())]
        );

        $user = User::create($data);

        event(new Registered($user));

        return $this->transformer->fromEntity($user);
    }
}
