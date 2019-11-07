<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_event', DateType::class, ['widget' => 'single_text'])
            ->add('format', ChoiceType::class, [
                'choices' => [
                    'Evènement Public' => 'publicEvent',
                    'Evènement Privé' => 'privateEvent',
                    'News' => 'news',
                    'Release' => 'releases',
                    'Membres' => 'members'
                ]
            ])
            ->add('title', TextType::class)
            ->add('text', TextareaType::class, ['required' => false])
            ->add('imgs', FileType::class, [
                'label' => "Ajouter une image",
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2Gi',
                        'mimeTypes' => [
                            'image/*',
                            ],
                        'mimeTypesMessage' => 'Envoie une image valide wesh, vérifie le format (png, jpg ou svg) ou la taille (max 10Mo)'
                        ])
                    ],
            ])
            ->add('api_data', TextType::class, ['required' => false])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        // return FormType::class to modify (nearly) every field in the system
        return [FileType::class];
    }
}
