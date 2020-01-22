<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_event', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                ])
            ->add('format', ChoiceType::class, [
                'choices' => [
                    'Public event' => 'public-event',
                    'Private event' => 'private-event',
                    'Release' => 'releases',
                    'Artist' => 'members',
                ]
            ])
            ->add('title', TextType::class)
            ->add('text', TextareaType::class, ['required' => false])
            ->add('imgsFile', FileType::class, [
                'multiple' => true,
                'required' => false,
            ])
            ->add('socialNetwork', SocialNetworkType::class)
            ->add('api_data', CollectionType::class, [
                'allow_delete' => true,
                'delete_empty' => true,
                'allow_add' => true,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'soundcloud_url',
                        'placeholder' => 'Une url stp',
                    ]
                ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    /*
        ->add('text', CollectionType::class, [
            'entry_type' => TextType::class, 
            'entry_option' => [
                'fr' => TextType::class,
                'en' => TextType::class,
            ]
        ])
    */
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            ]);
    }
}   
