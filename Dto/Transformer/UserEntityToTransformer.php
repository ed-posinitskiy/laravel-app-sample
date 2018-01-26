<?php

namespace App\Dto\Transformer;

use App\Dto\UserEntityTo;
use App\Model\User;
use AutoMapperPlus\AutoMapperInterface;

/**
 * Class UserEntityToTransformer
 *
 * @package App\Dto\Transformer
 */
class UserEntityToTransformer
{
    /**
     * @var AutoMapperInterface
     */
    protected $mapper;

    /**
     * UserModelToTransformer constructor.
     *
     * @param AutoMapperInterface $mapper
     */
    public function __construct(AutoMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param User $entity
     *
     * @return UserEntityTo
     */
    public function fromEntity(User $entity): UserEntityTo
    {
        return $this->fromEntityWith($entity, new UserEntityTo());
    }

    /**
     * @param User         $entity
     * @param UserEntityTo $dto
     *
     * @return UserEntityTo
     */
    public function fromEntityWith(User $entity, UserEntityTo $dto): UserEntityTo
    {
        $this->mapper->mapToObject($entity, $dto);

        $dto->storeOriginal($entity);

        return $dto;
    }
}
