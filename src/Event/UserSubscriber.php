<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Authorization\UserAuthorizationChecker;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private array $methodsNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];

    private UserAuthorizationChecker $userAuthorizationChecker;

    public function __construct(UserAuthorizationChecker $userAuthorizationChecker)
    {
        $this->userAuthorizationChecker = $userAuthorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function check(ViewEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($entity instanceof User &&
            false === in_array($method, $this->methodsNotAllowed, true)
        ) {
            $this->userAuthorizationChecker->check($entity, $method);
        }
    }
}