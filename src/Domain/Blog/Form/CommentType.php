<?php

namespace App\Domain\Blog\Form;

use App\Domain\Blog\DataTransferObject\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CommentType extends AbstractType
{
    private AuthorizationCheckerInterface $autorizationChecker;

    public function __construct(AuthorizationCheckerInterface $autorizationChecker)
    {
        $this->autorizationChecker = $autorizationChecker;
    }

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

        if (!$this->autorizationChecker->isGranted("ROLE_USER")) {
            $builder->add("author", TextType::class, [
                "label" => "Pseudo :"
            ]);
        }
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