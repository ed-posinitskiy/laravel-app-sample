<?php

namespace App\Event;

use App\Dto\UserEntityTo;

/**
 * Class UserEvent
 *
 * @package App\Event
 */
class UserEvent
{

    const EVENT_PASSWORD_UPDATED = 'user.password.updated';

    const EVENT_USER_CREATED = 'user.created';

    /**
     * @var UserEntityTo
     */
    protected $user;

    /**
     * @var mixed
     */
    protected $payload;

    /**
     * UserEvent constructor.
     *
     * @param UserEntityTo $user
     */
    public function __construct(UserEntityTo $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserEntityTo
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     *
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }
}
