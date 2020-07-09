<?php

namespace App\Event;

use App\Entity\Checkin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Authorization\CheckinAuthorizationChecker;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckinSubscriber implements EventSubscriberInterface
{
    private array $methodsNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];

    private CheckinAuthorizationChecker $checkinAuthorizationChecker;

    public function __construct(CheckinAuthorizationChecker $checkinAuthorizationChecker)
    {
        $this->checkinAuthorizationChecker = $checkinAuthorizationChecker;
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

        if ($entity instanceof Checkin &&
            false === in_array($method, $this->methodsNotAllowed, true)
        ) {
            $this->checkinAuthorizationChecker->check($entity, $method);
        }
    }
}