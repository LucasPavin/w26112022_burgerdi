<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Meal;
use App\Repository\MealRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
            'attr'=> [
                'placeholder' => 'Nom de la catégorie',
                'class' => 'form-name-meal'
            ],
            'label' => 'Nom du plats',
            'label_attr' => [
                'class' => 'form-label-meal'
            ],
            'constraints' => [
                //Valide qu'une valeur n'est pas vide ≠ de chaîne * @Vich\Uploadable
                new Assert\Length(['min'=> '2' ,'max'=> '75']),
                new Assert\NotBlank()
            ]  
            ])
            ->add('id_meal', EntityType::class, [
                'class' => Meal::class,
                'query_builder' => function(MealRepository $r){
                    return $r->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                },
                'label' => 'Assignez a un plat ?',
                'choice_label' => 'name',
                'multiple' => true, 
                'expanded' => true,
                "by_reference" => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-submit'
                ],
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
