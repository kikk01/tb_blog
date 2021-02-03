<?php

namespace App\Domain\Blog\EventSubscriber;

use App\Application\Entity\Post;
use App\Infrastructure\Event\ReverseEvent;
use App\Infrastructure\Event\TransferEvent;
use Symfony\Component\Security\Core\Security;
use App\Infrastructure\Uploader\UploaderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostSubscriber implements EventSubscriberInterface
{
    private Security $security;

    private UploaderInterface $uploader;

    public function __construct(Security $security, UploaderInterface $uploader)
    {
        $this->security = $security;
        $this->uploader = $uploader;
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
        if (!$event->getOriginalData() instanceof Post) {
            return;
        }
        
        $event->getData()->setTitle($event->getOriginalData()->getTitle());
        $event->getData()->setContent($event->getOriginalData()->getContent());
    }

    public function onReverse(ReverseEvent $event): void
    {
        if (!$event->getOriginalData() instanceof Post) {
            return;
        }

        if ($event->getData()->getImage() !== null) {
            $event->getOriginalData()->setImage($this->uploader->upload($event->getData()->getImage()));              
        }

        $event->getOriginalData()->setUser($this->security->getUser());
        $event->getOriginalData()->setTitle($event->getData()->getTitle());
        $event->getOriginalData()->setContent($event->getData()->getContent());
    }
}