<?php

namespace App\Form;

use App\Entity\Currency;
use App\Entity\Payment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currency', EntityType::class, [
                'class'  => Currency::class,
                'placeholder' => 'Seleccione una moneda',
                'label' => 'Moneda',
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Importe',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'required' => true,
            ])
            ->add('paymentType', ChoiceType::class, [
                'label' => 'Tipo de pago',
                'attr' => [
                    'class' => 'data-choices data-choices-groups data-choices-search-true',
                    'autocomplete' => 'off',
                ],
                'choices' => [
                    'Pago electrónico'=>'Pago electrónico',
                    'Paypal' => 'Paypal',
                    'Tarjeta' => 'Tarjeta',
                    'Efectivo' => 'Efectivo',
                    'Transferencia' => 'Transferencia',
                ],
                'required' => true,
            ])
            ->add('voucher', TextType::class, [
                'label' => 'No. de factura',
                'attr' => ['autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Nota',
                'attr' => [
                    'rows' => '3',
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ]);

        if ($options['file']) {
            $builder
                ->add('voucherFileType', FileType::class, [
                    'label' => 'Factura Fiscal Archivo',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '500M',
                            'mimeTypes' => [],
                            'mimeTypesMessage' => 'Please upload a valid document',
                        ]),
                    ],
                ]);
        }

        if (!$options['file']) {
            $builder
                ->add('voucherUrlFile', TextType::class, [
                    'label' => 'Url',
                    'attr' => ['autocomplete' => 'off', 'readonly' => 'readonly'],
                    'required' => true,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
            'file' => true,
        ]);
    }
}
