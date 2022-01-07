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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'text-center'
                ]
                ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'text-center'
                ]
                ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'text-center'
                ]
                ])
            ->add('old_password', PasswordType::class, [
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' =>
                    'Mot De Passe Actuel',
                    'class' => 'text-center'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et sa confirmation doivent être identiques',
                'label' => 'Nouveau Mot De Passe',
                'required' => true,
                'first_options' => ['label' => false, 'attr' => [
                    'placeholder' => 'Nouveau Mot De Passe',
                    'class'=> 'text-center']],
                'second_options' => ['label' => false, 'attr' => [
                    'placeholder' => 'Confirmer',
                    'class' => 'text-center']],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-block btn-warning text-light'
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
