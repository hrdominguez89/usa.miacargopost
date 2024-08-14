<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apiId', TextType::class, [
                'label' => 'API ID',
                'attr' => [
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Apellidos',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('cellPhone', TextType::class, [
                'label' => 'Celular',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('customerType', ChoiceType::class, [
                'label' => 'Tipo de cliente',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'choices' => [
                    'Empresa' => 'Empresa',
                    'Persona' => 'Persona',
                ],
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Estado',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'choices' => [
                    'Activado' => 1,
                    'Desactivado' => 0,
                ],
                'required' => true,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Género',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'choices' => [
                    'Masculino' => 'Masculino',
                    'Femenino' => 'Femenino',
                ],
            ])
            ->add('birthDay', BirthdayType::class, [
                'label' => 'Cumpleaños',
                'attr' => [
                    'autocomplete' => 'off',
                ],
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ],
                'required' => false,
            ])
            ->add('homeAddressId', NumberType::class, [
                'label' => 'API ID',
                'attr' => [
                    'min' => 1,
                    'max' => 10000,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('homeCountry', TextType::class, [
                'label' => 'País',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('homeState', TextType::class, [
                'label' => 'Estado',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('homeCity', TextType::class, [
                'label' => 'Ciudad',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('homeAddress', TextareaType::class, [
                'label' => 'Dirección',
                'attr' => [
                    'rows' => 3,
                    'maxlength' => 255,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('homePostalCode', TextType::class, [
                'label' => 'Código postal',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 50,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('homeAddInfo', TextareaType::class, [
                'label' => 'Adicional',
                'attr' => [
                    'rows' => 3,
                    'maxlength' => 255,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billAddressId', NumberType::class, [
                'label' => 'API ID',
                'attr' => [
                    'min' => 1,
                    'max' => 10000,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billCountry', TextType::class, [
                'label' => 'País',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billState', TextType::class, [
                'label' => 'Estado',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billCity', TextType::class, [
                'label' => 'Ciudad',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billAddress', TextareaType::class, [
                'label' => 'Dirección',
                'attr' => [
                    'rows' => 3,
                    'maxlength' => 255,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billPostalCode', TextType::class, [
                'label' => 'Código postal',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 50,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ])
            ->add('billAddInfo', TextareaType::class, [
                'label' => 'Adicional',
                'attr' => [
                    'rows' => 3,
                    'maxlength' => 255,
                    'autocomplete' => 'off',
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
