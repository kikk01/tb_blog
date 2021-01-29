<?php

namespace App\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

trait AuthorizationTrait
{
    private AuthorizationCheckerInterface $authorizationChecker;

    /**
     * @required
     */
    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker): void
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    protected function denyAccessUnlessGranted(string $attribute, ?object $subject = null): void
    {
        if (!$this->authorizationChecker->isGranted($attribute, $subject)) {
            throw new AccessDeniedException();
        }
    }

    protected function isGranted(string $attribute, ?object $subject = null): bool
    {
        return $this->authorizationChecker->isGranted($attribute, $subject);
    }
}