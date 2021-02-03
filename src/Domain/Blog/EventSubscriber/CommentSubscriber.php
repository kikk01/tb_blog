<?php

namespace App\Domain\Blog\EventSubscriber;

use App\Application\Entity\Comment;
use App\Infrastructure\Event\ReverseEvent;
use App\Infrastructure\Event\TransferEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommentSubscriber implements EventSubscriberInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public static function getSubscribedEvents()
    {
        return [
            TransferEvent::NAME => "onTransfer",
            ReverseEvent::NAME => "onReverse"
        ];
    }

    public function onTransfer(TransferEvent $event): void
    {
        if (!$event->getOriginalData() instanceof Comment) {
            return;
        }
        
        $event->getData()->setAuthor($event->getOriginalData()->getAuthor());
        $event->getData()->setContent($event->getOriginalData()->getContent());
    }

    public function onReverse(ReverseEvent $event): void
    {
        if (!$event->getOriginalData() instanceof Comment) {
            return;
        }
        
        if ($this->security->isGranted("ROLE_USER")) {
            $event->getOriginalData()->setUser($this->security->getUser());
        }

        $event->getOriginalData()->setAuthor($event->getData()->getAuthor());
        $event->getOriginalData()->setContent($event->getData()->getContent());
    }
}