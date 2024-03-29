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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' =>33
                ]),
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'text-center'
                ]
            ])
            ->add( 'firstname', TextType::class, [
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' =>33
                ]),
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'text-center'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' =>33
                ]),
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'text-center'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et sa confirmation doivent être identiques',
                'label' => 'Mot De Passe',
                'required' => true,
                'first_options' => [
                    'label' => false, 
                    'attr' => ['placeholder' => 'Mot De Passe',
                        'class'=> 'text-center'
                        ],
                ],
                'second_options' => [
                    'label' => false, 
                    'attr' => ['placeholder' => 'Confirmer',
                        'class'=> 'text-center'
                        ],
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-block btn-success text-light'
                ]
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
