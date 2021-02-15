<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'disabled' => true,
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Titre',
                    'class' => 'placeholder-custmomized'
                ]
            ])
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
            ->add('address', TextType::class, [
                'disabled' => true,
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'placeholder-custmomized'
                ]
            ])
            ->add('postal', TextType::class, [
                'disabled' => true,
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Code Postal',
                    'class' => 'placeholder-custmomized'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'placeholder-custmomized'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Pays',
                    'class' => 'placeholder-custmomized'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => false,
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Phone',
                    'class' => 'placeholder-custmomized'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => ' Ajouter mon adresse',
                'attr' => [
                    'class' => 'btn btn-warning fas fa-map-marker-alt text-white'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
