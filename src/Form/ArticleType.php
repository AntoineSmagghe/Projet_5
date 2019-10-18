<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_event', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'évènement',
            ])
            ->add('format', ChoiceType::class, [
                'label' => 'Type de l\'article',
                'placeholder' => 'Sélectionnez ici',
                'choices' => [
                    'Event Public' => 'publicEvent',
                    'Event Privé' => 'privateEvent',
                    'News' => 'news',
                    'Release' => 'releases',
                    'Membres' => 'members'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre de l\'article',
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Contenu de l\'article',
                'attr' => [
                    'class'=>'ckeditor',
                    'placeholder' => 'Tappez le texte ici'
                ]
            ])
            ->add('api_data', TextType::class, [
                'label' => 'Données de l\'api',
                'attr' => [
                    'placeholder' => 'Entrez des URL',
                ],
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
            ])
            //->add('id_img')  
            //->add('id_admin')
            //->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
