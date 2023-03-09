<?php

namespace App\Form;

use App\Entity\Meal;
use App\Entity\Agency;
use App\Repository\AgencyRepository;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=> [
                    'placeholder' => 'Nom du plat',
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
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image du plat',
                'required' => false,
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr'=> [
                    'placeholder' => 'Description du plat',
                    'class' => 'form-desc-meal'
                ],
                'label' => 'Description du plats',
                'label_attr' => [
                    'class' => 'form-label-meal'
                ],
                'constraints' => [
                    //Valide qu'une valeur n'est pas vide ≠ de chaîne * @Vich\Uploadable
                    new Assert\Length(['min'=> '50'],),
                    new Assert\NotBlank()
                ]  
            ])
            ->add('price', MoneyType::class, [
                'attr'=> [
                    'placeholder' => 'Prix du plat',
                    'class' => 'form-price-meal'
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label-meal'
                ],
                'constraints' => [
                    //Valide qu'une valeur n'est pas vide ≠ de chaîne * @Vich\Uploadable
                    new Assert\NotBlank()
                ]  
            ])
            ->add('calorie', NumberType::class, [
                'attr'=> [
                    'placeholder' => 'Calorie du plat (facultatif)',
                    'class' => 'form-calorie-meal'
                ],
                'required' => false,
                'label' => 'Calorie',
                'label_attr' => [
                    'class' => 'form-label-meal'
                ]
            ])
            ->add('id_agency', EntityType::class, [
                'class' => Agency::class,
                // Creation d'une query_builder
                'query_builder' => function(AgencyRepository $r){
                    return $r->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                },
                'placeholder' => 'Choissisez un restaurant',
                'label' => 'Restaurant',
                'choice_label' => 'name'
            ])
            ->add('id_category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(CategoryRepository $r){
                    return $r->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                },
                'label' => 'Categorie(s)',
                'choice_label' => 'name',
                'multiple' => true, 
                'expanded' => true,
                'by_reference' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-submit'
                ],
                'label' => 'Créer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
