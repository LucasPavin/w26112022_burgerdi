<?php

namespace App\Form;

use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class AgencyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option): void 
    {
        $builder    
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom du restaurant',
                    'class' => 'class-input-name',
                ],
                'label' => 'Nom du restaurant',
                'label_attr' => [
                    'class' => 'class-label-name'
                ],
                //Ensemble de contrainte pour pas qu'il est de mauvaise donnée.
                'constraints' => [
                    //Valide qu'une valeur n'est pas vide ≠ de chaîne vide
                    new Assert\NotBlank()
                ]               
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse du restaurant',
                    'class' => 'class-input-address',
                ],
                'label' => 'Adresse du restaurant',
                'label_attr' => [
                    'class' => 'class-label-address'
                ],
                //Ensemble de contrainte pour pas qu'il est de mauvaise donnée.
                'constraints' => [
                    //Valide qu'une valeur n'est pas vide ≠ de chaîne vide
                    new Assert\NotBlank()
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ville du restaurant',
                    'class' => 'class-input-city',
                ],
                'label' => 'Ville du restaurant',
                'label_attr' => [
                    'class' => 'class-label-addrecityss'
                ],
                //Ensemble de contrainte pour pas qu'il est de mauvaise donnée.
                'constraints' => [
                    //Valide qu'une valeur n'est pas vide ≠ de chaîne vide
                    new Assert\NotBlank()
                ]
            ])
            ->add('website', TextType::class, [
                'attr' => [
                    'placeholder' => 'Site du restaurant',
                    'class' => 'class-input-website',
                ],
                'label' => 'Site du restaurant',
                'label_attr' => [
                    'class' => 'class-label-website'
                ],
                //Ensemble de contrainte pour pas qu'il est de mauvaise donnée.
                'constraints' => [
                    //Valide qu'une valeur n'est pas vide ≠ de chaîne vide
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-submit'
                ],
                'label' => 'Valider'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void 
    {
        $resolver->setDefaults([
            'data_class' => Agency::Class
        ]);
    }
}