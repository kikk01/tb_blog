<?php

namespace App\Form;

use App\DataTransferObject\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class PostType
 * @package App\Form
 */
class PostType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextareaType::class, [
                'label' => 'Titre :'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Article'
            ])
            ->add('image', FileType::class,  [
                'required' => false,
                'constraints' => [
                    new Image(),
                    new NotNull([
                        "groups" => 'create'
                    ])
                ]
            ])
        ;
    }

    /**
     * 
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Post::class);
    }
}