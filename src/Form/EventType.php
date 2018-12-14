<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'label' => "Nom de l'événement *"
                ]
            )
            ->add('eventDate',
                DateTimeType::class,
                [
                    'label' => "Date de l'événement *",
                    'placeholder' => array(
                        'year' => 'Année',
                        'month' => 'Mois',
                        'day' => 'Jour',
                        'hour' => 'Heure',
                        'minute' => 'Minute',
                        'second' => 'Second'),
                    'years' =>
                    [
                        '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028'
                    ],
                    'minutes' => [
                        '00', '15', '30', '45'
                    ]

                ]
            )
            ->add('description',
                TextareaType::class,
                [
                    'label' => "Description *"
                ]
            )
            ->add('artist',
                TextType::class,
                [
                    'label' => "Artistes de l'événement *"
                ]
            )
            ->add('style',
                TextType::class,
                [
                    'label' => "Style(s) de musique *"
                ]
            )
//            ->add('image',
//                FileType::class,
//                [
//                    'label' => "Photo de l'événement",
//                    'required' => false
//                ]
//            )
            ->add('urlEvent',
                UrlType::class,
                [
                    'label' => "Lien vers le site de l'événement",
                    'required' => false
                ]
            )
            ->add('urlTicketing',
                UrlType::class,
                [
                    'label' => "Lien vers la billeterie de l'événement",
                    'required' => false
                ]
            )
            ->add('price',
                TextType::class,
                [
                    'label' => "Prix (approximatif)",
                    'required' => false
                ]
            )
            ->add('place',
                EntityType::class,
                [
                    'class' => Place::class,
                    'label' => "Lieu de l'événement",
                    'choice_label' => 'name',
                    'placeholder' => 'Choisissez un lieu...'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
