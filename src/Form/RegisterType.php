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

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'erreur de saisie',
                'required' => true,
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot De Passe',
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
                'label' => 'Valider'
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
