<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                TextType::class,
                [
                    'label' => 'Nom du lieu *'
                ]
                )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email du lieu *'
                ]
                )
            ->add('phone',
                TelType::class,
                [
                    'label' => 'Téléphone *'
                ]
                )
            ->add('streetNumber',
                IntegerType::class,
                [
                    'label' => 'Numéro *',
                    'attr' =>
                        [
                            'class' => 'adresse'
                        ]
                ]
                )
            ->add('streetName',
                TextType::class,
                [
                    'label'=> 'Type et nom de la voie *',
                    'attr' =>
                        [
                            'class' => 'adresse'
                        ]
                ]
                )
            ->add('zipCode',
                IntegerType::class,
                [
                    'label' => 'Code postal / ZIP code *',
                    'attr' =>
                        [
                            'class' => 'adresse'
                        ]
                ]
                )
            ->add('town',
                TextType::class,
                [
                    'label' => 'Ville',
                    'attr' =>
                    [
                        'class' => 'adresse'
                    ]
                ]
            )
            ->add('lon',
                TextType::class,
                [
                    'label' => 'longitude'
                ]
                )
            ->add('lat',
                TextType::class,
                [
                    'label' => 'latitude'
                ]
                )
            ->add('description',
                TextareaType::class,
                [
                    'label' => "Description *"
                ]
            )
            ->add('owner',
                EntityType::class,
                [
                    'label' => 'Propriétaire',
                    'data' => 'Propiétaire inconnu',
                    'class' => User::class,
                    'expanded' => false,
                    'multiple' => false
                ]
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
