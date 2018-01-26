<?php

namespace App\Service;

use App\Dto\Transformer\UserEntityToTransformer;
use App\Dto\UserAttributesVo;
use App\Dto\UserEntityTo;
use App\Event\UserEvent;
use App\Model\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Events\Dispatcher;

/**
 * Class UserService
 */
class UserService
{

    /**
     * @var AuthManager
     */
    protected $auth;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var UserEntityToTransformer
     */
    protected $transformer;

    /**
     * UserService constructor.
     *
     * @param AuthManager             $auth
     * @param Dispatcher              $events
     * @param UserEntityToTransformer $transformer
     */
    public function __construct(AuthManager $auth, Dispatcher $events, UserEntityToTransformer $transformer)
    {
        $this->auth        = $auth;
        $this->events      = $events;
        $this->transformer = $transformer;
    }

    /**
     * @return UserEntityTo
     * @throws AuthenticationException
     */
    public function getCurrent()
    {
        $user = $this->auth->guard()->user();

        if (!$user) {
            throw new AuthenticationException('User is not authenticated');
        }

        return $this->assembleUserTo($user);
    }

    /**
     * @param string $username
     *
     * @return UserEntityTo
     * @throws ModelNotFoundException
     */
    public function findByUsername($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return $this->assembleUserTo($user);
    }

    /**
     * @param UserEntityTo $user
     * @param string       $password
     *
     * @return UserEntityTo
     */
    public function updatePassword(UserEntityTo $user, $password)
    {
        /** @var User $model */
        $model = $user->getOriginal() ?: User::findOrFail($user->getId());

        $model->update(['password' => bcrypt($password)]);

        $user = $this->assembleUserTo($model, $user);

        $event = new UserEvent($user);
        $event->setPayload($password);

        $this->events->fire(UserEvent::EVENT_PASSWORD_UPDATED, $event);

        return $user;
    }

    /**
     * @param User             $user
     * @param UserAttributesVo $dto
     *
     * @return UserEntityTo
     */
    public function update(User $user, UserAttributesVo $dto)
    {
        $user->fill($dto->toArray());
        $user->save();

        return $this->transformer->fromEntity($user);
    }

    /**
     * @param User|Model        $entity
     * @param UserEntityTo|null $dto
     *
     * @return UserEntityTo
     */
    protected function assembleUserTo(User $entity, UserEntityTo $dto = null)
    {
        return $dto
            ? $this->transformer->fromEntityWith($entity, $dto)
            : $this->transformer->fromEntity($entity);
    }
}
