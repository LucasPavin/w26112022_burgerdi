<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder ->add('lastname', TextType::class, [
            'attr' => [
                'class' => 'form-name-registration',
                'minlenght' => '2',
                'max-lenght' => '50'
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label-registration'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50]),
            ]
        ])
        ->add('firstname', TextType::class, [
            'attr' => [
                'class' => 'form-name-registration',
                'minlenght' => '2',
                'max-lenght' => '50'
            ],
            'label' => 'Prénom',
            'label_attr' => [
                'class' => 'form-label-registration'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50]),
            ]
        ])
        ->add('email')
        ->add('phone', TextType::class, [
            'attr' => [
                'class' => 'form-name-registration',
                'minlenght' => '2',
                'max-lenght' => '50'
            ],
            'label' => 'Téléphone',
            'label_attr' => [
                'class' => 'form-label-registration'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 180]),
            ]
        ])
        ->add('city', TextType::class, [
            'attr' => [
                'class' => 'form-name-registration',
                'minlenght' => '2',
                'max-lenght' => '50',
            ],
            'label' => 'Nom de ville',
            'label_attr' => [
                'class' => 'form-label-registration'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 180]),
            ]
        ])
        ->add('plainPassword', PasswordType::class, [
            'attr' => [
                'class' => 'form-name-registration'
            ],
            'label' => 'Mot de passe',
            'label_attr' => [
                'class' => 'form-label-registration'
            ],
            'invalid_message' => 'Le mots de passe ne correspond pas.'
        ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
