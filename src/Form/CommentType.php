<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class CommentType
 * @package App\Form
 */
class CommentType extends AbstractType
{
    /**
     * @inheritdoc
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("content", TextareaType::class, [
                "label" => "Votre message",
                "attr" => ["class" => "form-control"],
                "row_attr" => ["class" => "form-group"],
                "label_attr" => ["class" => "label_attr"]
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $formEvent) {
            if ($formEvent->getData()->getUser() !== null) {
                return;
            }

            $formEvent->getForm()->add("author", TextType::class, [
                "label" => "Pseudo :"
            ]);
        });
    }

    /**
     * @inheritDoc
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Comment::class);
    }



}