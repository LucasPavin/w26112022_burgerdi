<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => "Dupont",
                    'class' => 'form-name-registration',
                    'minlenght' => '2',
                    'max-lenght' => '46'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label-registration'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 46]),
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => "Georges",
                    'class' => 'form-name-registration',
                    'minlenght' => '2',
                    'max-lenght' => '46'
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label-registration'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 46]),
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => "georges.dupont@burgerdi.fr",
                    'class' => 'form-name-registration',
                    'minlenght' => '2',
                    'max-lenght' => '62'
                ],
                'label' => 'Adresse e-mail',
                'label_attr' => [
                    'class' => 'form-label-registration'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 62]),
                ]
            ])
            ->add('phone', NumberType::class, [
                'attr' => [
                    'placeholder' => "06 ** ** ** **",
                    'class' => 'form-name-registration',
                    'minlenght' => '2',
                    'max-lenght' => '15'
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form-label-registration'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 15]),
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => "Vern-Sur-Seiche",
                    'class' => 'form-name-registration',
                    'minlenght' => '2',
                    'max-lenght' => '35'
                ],
                'label' => 'Nom de ville',
                'label_attr' => [
                    'class' => 'form-label-registration'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 35]),
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add("Inscription", SubmitType::class, [
                'attr' => [
                    'class' => 'btn'
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
