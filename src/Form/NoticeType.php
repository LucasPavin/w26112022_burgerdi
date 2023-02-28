<?php

namespace App\Form;

use App\Entity\Notice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', ChoiceType::class, [
                'placeholder' => 'Choisissez une note',
                'choices' => [
                    '5' => 5,
                    '4' => 4,
                    '3' => 3,
                    '2' => 2,
                    '1' => 1,
                ],
                'label' => 'Quel note donnez-vous ?',
                'attr' => [
                    'class' => 'form-select',
                ],
                'label_attr' => [
                    'class' => 'form-label-select'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'attr'=> [
                    'class' => 'form-desc-meal',
                    'placeholder' => 'Écrivez un commentaire au sujet de ce plat...',
                ],
                'label' => 'Votre commentaire',
                'required' => false,
                'label_attr' => [
                    'class' => 'form-label-meal'
                ], 
            ])
            
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
