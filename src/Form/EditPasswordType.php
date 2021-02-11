<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstName', TextType::class, [
            'disabled' => true,
            'label' => false,
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'Prénom',
                'class' => 'placeholder-custmomized'
            ]
        ])
        ->add('lastName', TextType::class, [
            'disabled' => true,
            'label' => false,
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'Nom',
                'class' => 'placeholder-custmomized'
            ]
        ])
        ->add('email', EmailType::class, [
            'disabled' => true,
            'label' => false,
            'constraints' => new Length([
                'min' => 2,
                'max' => 50
            ]),
            'attr' => [
                'placeholder' => 'Email',
                'class' => 'placeholder-custmomized'
            ]
        ])
        ->add('old_password', PasswordType::class, [
            'label' => false,
            'mapped' => false,
            'attr' => [
                'placeholder' => 'Mot De Passe Actuel',
                'class' => 'placeholder-custmomized'
            ]
        ])
        ->add('new_password', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'erreur de saisie',
            'required' => true,
            'first_options' => [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nouveau Mot De Passe',
                    'onpaste' => 'return false',
                    'class' => 'placeholder-custmomized'
                ]
            ],
            'second_options' => [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Confirmer',
                    'class' => 'placeholder-custmomized'
                ]
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
