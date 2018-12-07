<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'Nom'
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'Prénom'
                ]
            )

            ->add(
                'birthdate', // TODO revoir le format de la date
                BirthdayType::class,
                [
                    'label' => 'Date de naissance'
                ]
            )

            ->add(
                'pseudo',
                TextType::class,
                [
                    'label' => 'Pseudo'
                ]
            )

            ->add(
                'adress',
                TextType::class,
                [
                    'label' => 'Adresse'
                ]
            )

            ->add(
                'zipCode',
                TextType::class,
                [
                    'label' => 'Code postal'
                ]
            )

            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'Téléphone',
                    'required' => false
                ]
            )

            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email'
                ]
            )

            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de passe'
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe'
                    ],
                    'invalid_message' => 'La confirmation ne correspond pas au mot de passe.'
                ]
            )

            ->add(
                'image',
                FileType::class,
                [
                    'label' => 'Photo',
                    'required' => false
                ]
            )

            ->add(
                'styles',
                TextType::class,
                [
                    'label' => 'Style de musique',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
