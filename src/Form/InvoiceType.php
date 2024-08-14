<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statusInvoice', ChoiceType::class, [
                'label' => 'Estado de la factura',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'choices' => [
                    'ABIERTO' => 'OPEN',
                    'CANCELADO' => 'CANCELED',
                    'PAGADO' => 'PAID',
                ],
                'required' => true,
            ])
            // ->add('fiscalInvoiceNumber', TextType::class, [
            //     'label' => 'Factura fiscal Nro.',
            //     'attr' => ['autocomplete' => 'off'],
            //     'required' => false,
            // ])
            ->add('paymentDeadlineInvoice', ChoiceType::class, [
                'label' => 'Fecha límite',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'choices' => [
                    'PAGO 07 días' => '7d',
                    'PAGO 30 días' => '30d',
                    'PAGO 45 días' => '45d',
                    'PAGO 60 días' => '60d',
                    'PAGO 90 días' => '90d',
                    'PAGO 24 hs' => '24h',
                    'PAGO 48 hs' => '48h',
                    'PAGO 72 hs' => '72h',
                ],
                'group_by' => function (?string $entity) {

                    if (str_contains(strtolower($entity), 'h')) {
                        return 'HORAS';
                    }

                    return "DÍAS";

                },
                'required' => true,
            ])
            ->add('flete', MoneyType::class, [
                'label' => false,
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'class' => 'form-control bg-light',
                ],
            ])
            // ->add('fuel', MoneyType::class, [
            //     'label' => false,
            //     'scale' => 2,
            //     'currency' => 'USD',
            //     'attr' => [
            //         'class' => 'form-control bg-light',
            //     ],
            // ])
            ->add('sure', MoneyType::class, [
                'label' => false,
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'class' => 'form-control bg-light',
                ],
            ])
            ->add('otherService', MoneyType::class, [
                'label' => false,
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'class' => 'form-control bg-light',
                ],
            ]);
            // if ($options['file']) {
            //     $builder
            //         ->add('fiscalInvoiceFileType', FileType::class, [
            //             'label' => 'Factura fiscal',
            //             'mapped' => false,
            //             'required' => false,
            //             'constraints' => [
            //                 new File([
            //                     'maxSize' => '500M',
            //                     'mimeTypes' => [],
            //                     'mimeTypesMessage' => 'Please upload a valid document',
            //                 ]),
            //             ],
            //         ]);
            // }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
            // 'file' => true,
        ]);
    }
}
