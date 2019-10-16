<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('text', TextareaType::class, [
                'attr' => ['class'=>'ckeditor']
            ])
            ->add('date_event', DateType::class, [
                'widget' => 'single_text'
            ])
            //->add('id_img')
            ->add('format', ChoiceType::class, [
                'required' => true,
                'placeholder' => 'Choississez un type',
                'choices' => [
                    'Event Public' => 'publicEvent',
                    'Event Privé' => 'privateEvent',
                    'News' => 'news',
                    'Release' => 'releases',
                    'Membres' => 'members'
                ]
            ])
            ->add('api_data')   
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
