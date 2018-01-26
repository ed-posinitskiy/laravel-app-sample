<?php
/**
 * File contains Class UserEventSubscriber
 *
 * @since  15.11.2017
 * @author Alexandra Fedotova <afedotova.kappa@gmail.com>
 */

namespace App\Listeners;

use App\Auth\AccessRegistry;
use App\Event\UserEvent;
use App\Model\User;
use Illuminate\Events\Dispatcher;

/**
 * Class UserEventSubscriber
 *
 * @package App\Listeners
 * @author  Alexandra Fedotova <afedotova.kappa@gmail.com>
 */
class UserEventSubscriber
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserEvent::EVENT_USER_CREATED, 'App\Listeners\UserEventSubscriber@onCreate');
    }

    /**
     * @param UserEvent $event
     */
    public function onCreate(UserEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser()->getOriginal();
        $user->attachRole(AccessRegistry::R_EMPLOYEE);
    }
}
