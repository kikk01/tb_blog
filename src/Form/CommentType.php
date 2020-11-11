<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add("author", TextType::class, [
                "label" => "Pseudo :"
            ])
            ->add("content", TextareaType::class, [
                "label" => "Votre message",
                "attr" => ["class" => "form-control"],
                "row_attr" => ["class" => "form-group"],
                "label_attr" => ["class" => "label_attr"]
            ])
        ;
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