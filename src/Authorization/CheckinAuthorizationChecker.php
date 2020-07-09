<?php

namespace App\Authorization;

use App\Entity\Checkin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CheckinAuthorizationChecker
{
    private array $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE
    ];

    const ERR_NOT_AUTH = "You are not authenticated";
    const ERR_NOT_ALLOW = "You are not allowed to access to that ressource";

    private ?UserInterface $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function check(Checkin $checkin, string $method): void
    {
        $this->isAuthenticated();
        $roles = $this->user->getRoles();
        $user_owner = $checkin->getUser();

        if ($this->isMethodAllowed($method) &&
            $user_owner->getId() !== $this->user->getId() &&
            false === in_array('ROLE_ADMIN', $roles, true)
        ) {
            throw new UnauthorizedHttpException(self::ERR_NOT_ALLOW, self::ERR_NOT_ALLOW);
        }
    }

    public function isAuthenticated(): void
    {
        if (null === $this->user) {
            throw new UnauthorizedHttpException(self::ERR_NOT_AUTH, self::ERR_NOT_AUTH);
        }
    }

    public function isMethodAllowed(string $method): bool
    {
        return in_array($method, $this->methodAllowed, true);
    }
}