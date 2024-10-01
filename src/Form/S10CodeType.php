<?php

namespace App\Form;

use App\Entity\CategoryDocument;
use App\Entity\CategoryItem;
use App\Entity\Country;
use App\Entity\PostalProduct;
use App\Entity\S10Code;
use App\Repository\PostalProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class S10CodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('postalProduct', EntityType::class, [
                'placeholder' => 'Seleccione un tipo de producto',
                'label' => 'Tipo de producto  <span class="text-danger">*</span>',
                'label_html' => true,
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
                'label' => 'Tipo de servicio  <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'mapped' => false,
                'disabled' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo tipo de servicio es obligatorio']),
                ]
            ])
            ->add('toCountry', EntityType::class, [
                'placeholder' => 'Seleccione país de destino',
                'label' => 'País destino  <span class="text-danger">*</span>',
                'label_html' => true,
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
            ->add('fromName', TextType::class, [
                'label' => 'Apellido y Nombre <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Apellido y Nombre es obligatorio']),
                ]
            ])
            ->add('fromStreet', TextType::class, [
                'label' => 'Calle <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Calle es obligatorio']),
                ]
            ])
            ->add('fromCountry', EntityType::class, [
                'placeholder' => 'Seleccione país',
                'label' => 'País <span class="text-danger">*</span>',
                'label_html' => true,
                'class'  => Country::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    // 'class' => 'js-example-basic-single',
                    'data-choices' => null,
                    'data-choice' => 'active',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'El campo País es obligatorio']),
                ]
            ])
            ->add('fromCity', TextType::class, [
                'label' => 'Ciudad <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Ciudad es obligatorio']),
                ]
            ])
            ->add('fromPostcode', TextType::class, [
                'label' => 'Cód. Postal <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Cód. Postal es obligatorio']),
                ]
            ])

            ->add('fromTel', TelType::class, [
                'label' => 'Tel <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Teléfono es obligatorio']),
                ]
            ])
            ->add('fromEmail', EmailType::class, [
                'label' => 'E-mail <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo E-mail es obligatorio']),
                ]
            ])
            ->add('sendersCustomsReference', TextType::class, [
                'label' => "Referencia aduanera del expedidor",
                'label_html' => true,
                'required' => false
            ])
            ->add('toName', TextType::class, [
                'label' => 'Apellido y Nombre <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Apellido y Nombre es obligatorio']),
                ]
            ])
            ->add('toStreet', TextType::class, [
                'label' => 'Calle <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Calle es obligatorio']),
                ]
            ])
            ->add('toCity', TextType::class, [
                'label' => 'Ciudad <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Ciudad es obligatorio']),
                ]
            ])
            ->add('toPostcode', TextType::class, [
                'label' => 'Cód. Postal <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Cód. Postal es obligatorio']),
                ]
            ])
            ->add('toTel', TelType::class, [
                'label' => 'Tel <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo Teléfono es obligatorio']),
                ]
            ])
            ->add('toEmail', EmailType::class, [
                'label' => 'E-mail <span class="text-danger">*</span>',
                'label_html' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo E-mail es obligatorio']),
                ]
            ])
            ->add('importersReference', TextType::class, [
                'label' => "Referencia del importador",
                'label_html' => true,
                'required' => false
            ])

            ->add('importersTel', TextType::class, [
                'label' => "Teléfono del importador",
                'label_html' => true,
                'required' => false
            ])
            ->add('itemDetails', CollectionType::class, [
                'entry_type' => ItemDetailType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false, // Necesario para manejar correctamente la colección
                'label' => 'Detalles de los ítems', // Etiqueta opcional
            ])
            ->add('categoryItem', EntityType::class, [
                'label' => ' ',
                'class' => CategoryItem::class,
                'choice_label' => 'name',
                'required' => false,
                'multiple' => true,
                'expanded' => true, // Cambiar a false para usar select en lugar de checkboxes
                'mapped' => false,
            ])
            ->add('categoryItemExplanation', TextareaType::class, [
                'label' => 'Explicación',
                'required' => false,
                'attr' => [
                    'rows' => 5
                ]
            ])
            ->add('comments', TextareaType::class, [
                'label' => 'Observaciones',
                'required' => false,
                'attr' => [
                    'rows' => 2
                ]
            ])
            ->add('categoryDocument', EntityType::class, [
                'placeholder' => 'Ninguno',
                'label' => 'Tipo de documento',
                'class'  => CategoryDocument::class,
                'choice_label' => 'name',
                'required' => false,
                'mapped' => true
            ])
            ->add('categoryDocuentNumber', TextType::class, [
                'label' => 'Número de documento',
                'required' => false
            ])
            ->add('acceptanceInfItemWeight', NumberType::class, [
                'label' => 'Peso',
                'scale' => 3, // Para definir hasta 3 decimales
                'constraints' => [
                    new Range([
                        'min' => 0, // Si necesitas un valor mínimo
                        'max' => 9999999.999, // Define el rango si lo necesitas
                    ])
                ],
                'required' => false,
                'html5' => true, // Habilita el input HTML5
                'attr' => [
                    'step' => '0.001', // Permite valores de hasta 3 decimales
                ]
            ])
            ->add('acceptanceInfPostalChargesFees', MoneyType::class, [
                'label' => 'cargos postales',
                'currency' => 'USD',
                'required' => false,
            ])
            ->add('acceptanceInfInsurance', MoneyType::class, [
                'label' => 'Seguro',
                'currency' => 'USD',
                'required' => false,
            ])
            ->add('acceptanceInfTotal', MoneyType::class, [
                'label' => 'Total',
                'currency' => 'USD',
                'required' => false,
            ])
            ->add('acceptanceInfOffice', TextType::class, [
                'label' => 'Oficina',
                'required' => false
            ])
            ->add('acceptanceInfDateTime', DateTimeType::class, [
                'label' => 'Fecha y Horas',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Generar Codigo S10 y Formularios CN22/CN23',
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => S10Code::class,
        ]);
    }
}
