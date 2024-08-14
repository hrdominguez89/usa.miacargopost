<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'label' => 'Equipo',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
            ])
            ->add('customer', TextType::class, [
                'label' => 'Cliente asociado',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('orderId', TextType::class, [
                'label' => 'API ID',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('statusOrder', TextType::class, [
                'label' => 'Estado de la orden',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('wareHouseId', TextType::class, [
                'label' => 'Almacen ID',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('inventoryId', TextType::class, [
                'label' => 'Inventario ID',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shipping', TextType::class, [
                'label' => 'Envío',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingInternational', TextType::class, [
                'label' => 'Envío internacional',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('paymentFile', UrlType::class, [
                'label' => 'URL de pago',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('paymentReceivedFile', UrlType::class, [
                'label' => 'URL de recibo',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('debitCreditNoteFile', TextType::class, [
                'label' => 'Nota de crédito',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingCost', MoneyType::class, [
                'label' => 'Costo de envío',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippinDiscount', MoneyType::class, [
                'label' => 'Descuento de envío',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingCountry', TextType::class, [
                'label' => 'País',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingState', TextType::class, [
                'label' => 'Estado',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingCity', TextType::class, [
                'label' => 'Ciudad',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingAddress', TextType::class, [
                'label' => 'Dirección',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingPostalCode', TextType::class, [
                'label' => 'Código postal',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('shippingAddInfo', TextType::class, [
                'label' => 'Información adicional',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billFile', TextType::class, [
                'label' => 'URL de factura',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billAddressId', TextType::class, [
                'label' => 'Dirección ID',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billCountry', TextType::class, [
                'label' => 'País',
                'attr' => [
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billState', TextType::class, [
                'label' => 'Estado',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billCity', TextType::class, [
                'label' => 'Ciudad',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billAddress', TextType::class, [
                'label' => 'Dirección',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billPostalCode', TextType::class, [
                'label' => 'Código postal',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('billAddInfo', TextType::class, [
                'label' => 'Información adicional',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('subTotal', MoneyType::class, [
                'label' => 'Sub-total',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('productDiscount', MoneyType::class, [
                'label' => 'Descuento de producto',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('codePromoDiscount', MoneyType::class, [
                'label' => 'Descuento de promoción',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('tax', MoneyType::class, [
                'label' => 'Impuesto',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('totalOrder', MoneyType::class, [
                'label' => 'Total',
                'scale' => 2,
                'currency' => 'USD',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('dataJson', TextareaType::class, [
                'label' => 'Json',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ])
            ->add('dataUpdateJson', TextareaType::class, [
                'label' => 'Json',
                'attr' => [
                    'readonly' => 'readonly',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
