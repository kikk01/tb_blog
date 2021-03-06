<?php

namespace App\Infrastructure\Handler;


use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use App\Infrastructure\Event\ReverseEvent;
use App\Infrastructure\Event\TransferEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * class AbstractHandler
 * @package App\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @var FormInterface
     */
    protected FormInterface $form;

    abstract protected function getDataTransferObject(): object;

    /**
     *
     * @return string
     */
    abstract protected function getFormType(): string;

    /**
     *
     * @param $data
     * @return void
     */
    abstract protected function process($data): void;

    /**
     * @required
     */ 
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @required
     * @param  FormFactoryInterface  $formFactory
     *
     * @return  self
     */ 
    public function setFormFactory(FormFactoryInterface $formFactory) : void
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @inheritDoc
     */
    public function handle(Request $request, object $originalData, array $options = []): bool
    {
        $data = $this->getDataTransferObject();

        $this->eventDispatcher->dispatch(new TransferEvent($originalData, $data), TransferEvent::NAME);

        $this->form = $this->formFactory->create($this->getFormType(), $data, $options)->handleRequest($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->eventDispatcher->dispatch(new ReverseEvent($data, $originalData), ReverseEvent::NAME);
            $this->process($originalData);
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function createView(): FormView
    {
        return $this->form->createView();
    }
}
