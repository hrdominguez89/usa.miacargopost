<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\PostalProduct;
use App\Entity\S10Code;
use App\Repository\PostalProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class S10CodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('postalProduct', EntityType::class, [
                'placeholder' => 'Seleccione un tipo de producto',
                'label' => 'Tipo de producto',
                'class'  => PostalProduct::class,
                'choice_label' => 'name',
                'required' => true,
                'mapped' => false,
                'query_builder' => function (PostalProductRepository $pp) {
                    return $pp->createQueryBuilder('pp')
                        ->where('pp.name NOT IN (:names)')
                        ->setParameter('names', ['Unassigned', 'Reserved'])
                        ->orderBy('pp.name', 'ASC');
                },
                'constraints' => [
                    new NotBlank(['message' => 'El campo tipo de producto es obligatorio']),
                ]
            ])
            ->add('postalService', ChoiceType::class, [
                'placeholder' => 'Seleccione un tipo de servicio',
                'label' => 'Tipo de servicio',
                'required' => true,
                'mapped' => false,
                'disabled' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo tipo de servicio es obligatorio']),
                ]
            ])
            ->add('country', EntityType::class, [
                'placeholder' => 'Seleccione pais de destino',
                'label' => 'País destino',
                'class'  => Country::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'js-example-basic-single',
                    'data-choices' => null,
                    'data-choice' => 'active',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'El campo País es obligatorio']),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Generar Codigo S10',
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => S10Code::class,
        ]);
    }
}
