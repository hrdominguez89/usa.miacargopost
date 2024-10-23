<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZipCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firm', TextType::class, [
                'required' => false,
                'label' => 'Nombre de la empresa (Firm)',
                'label_html' => true, // Permitir HTML en el label
            ])
            ->add('streetAddress', TextType::class, [
                'label' => 'Dirección (Street Address) <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true, // Permitir HTML en el label
            ])
            ->add('secondaryAddress', TextType::class, [
                'required' => false,
                'label' => 'Dirección secundaria (Secondary Address)',
                'label_html' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ciudad (City) <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
            ])
            ->add('state', ChoiceType::class, [
                'label' => 'Estado (State) <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'choices' => [
                    'AA' => 'AA',
                    'AE' => 'AE',
                    'AL' => 'AL',
                    'AK' => 'AK',
                    'AP' => 'AP',
                    'AS' => 'AS',
                    'AZ' => 'AZ',
                    'AR' => 'AR',
                    'CA' => 'CA',
                    'CO' => 'CO',
                    'CT' => 'CT',
                    'DE' => 'DE',
                    'DC' => 'DC',
                    'FM' => 'FM',
                    'FL' => 'FL',
                    'GA' => 'GA',
                    'GU' => 'GU',
                    'HI' => 'HI',
                    'ID' => 'ID',
                    'IL' => 'IL',
                    'IN' => 'IN',
                    'IA' => 'IA',
                    'KS' => 'KS',
                    'KY' => 'KY',
                    'LA' => 'LA',
                    'ME' => 'ME',
                    'MH' => 'MH',
                    'MD' => 'MD',
                    'MA' => 'MA',
                    'MI' => 'MI',
                    'MN' => 'MN',
                    'MS' => 'MS',
                    'MO' => 'MO',
                    'MP' => 'MP',
                    'MT' => 'MT',
                    'NE' => 'NE',
                    'NV' => 'NV',
                    'NH' => 'NH',
                    'NJ' => 'NJ',
                    'NM' => 'NM',
                    'NY' => 'NY',
                    'NC' => 'NC',
                    'ND' => 'ND',
                    'OH' => 'OH',
                    'OK' => 'OK',
                    'OR' => 'OR',
                    'PW' => 'PW',
                    'PA' => 'PA',
                    'PR' => 'PR',
                    'RI' => 'RI',
                    'SC' => 'SC',
                    'SD' => 'SD',
                    'TN' => 'TN',
                    'TX' => 'TX',
                    'UT' => 'UT',
                    'VT' => 'VT',
                    'VI' => 'VI',
                    'VA' => 'VA',
                    'WA' => 'WA',
                    'WV' => 'WV',
                    'WI' => 'WI',
                    'WY' => 'WY'
                ],
                'placeholder' => 'Selecciona un estado',
            ])
            ->add('ZIPCode', TextType::class, [
                'label' => 'Código Postal (ZIP Code)',
                'required' => false,
                'label_html' => true,
            ])
            ->add('ZIPPlus4', TextType::class, [
                'label' => 'Código Postal +4 (ZIP+4)',
                'required' => false,
                'label_html' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
