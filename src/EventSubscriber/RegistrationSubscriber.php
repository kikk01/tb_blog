<?php

namespace App\EventSubscriber;

use App\Event\ReverseEvent;
use App\Event\TransferEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationSubscriber implements EventSubscriberInterface
{
    protected UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            TransferEvent::NAME => "onTransfer",
            ReverseEvent::NAME => "onReverse"
        ];
    }

    public function onTransfer(TransferEvent $event): void
    {
        return;
    }

    public function onReverse(ReverseEvent $event): void
    {
        $event->getOriginalData()->setPseudo($event->getData()->getPseudo());
        $event->getOriginalData()->setPassword(
            $this->userPasswordEncoder->encodePassword($event->getOriginalData(), $event->getData()->getPassword())
        );
        $event->getOriginalData()->setEmail($event->getData()->getEmail());
    }
}