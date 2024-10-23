<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomesticPricesBaseRatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originZIPCode', TextType::class, [
                'label' => 'Código Postal de Origen (ZIP Code) <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('destinationZIPCode', TextType::class, [
                'label' => 'Código Postal de Destino (ZIP Code) <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('weight', NumberType::class, [
                'label' => 'Peso (en libras) <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('length', NumberType::class, [
                'label' => 'Longitud (en pulgadas) <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('width', NumberType::class, [
                'label' => 'Ancho (en pulgadas) <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('height', NumberType::class, [
                'label' => 'Altura (en pulgadas) <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('mailClass', ChoiceType::class, [
                'label' => 'Clase de Correo (Mail Class) <span class="text-danger">*</span>',
                'choices' => [
                    'Parcel Select' => 'PARCEL_SELECT',
                    'Parcel Select Lightweight' => 'PARCEL_SELECT_LIGHTWEIGHT',
                    'Priority Mail Express' => 'PRIORITY_MAIL_EXPRESS',
                    'Priority Mail' => 'PRIORITY_MAIL',
                    'First-Class Package Service' => 'FIRST-CLASS_PACKAGE_SERVICE',
                    'Library Mail' => 'LIBRARY_MAIL',
                    'Media Mail' => 'MEDIA_MAIL',
                    'Bound Printed Matter' => 'BOUND_PRINTED_MATTER',
                    'USPS Connect Local' => 'USPS_CONNECT_LOCAL',
                    'USPS Ground Advantage' => 'USPS_GROUND_ADVANTAGE',
                    'Ground Return Service' => 'GROUND_RETURN_SERVICE',
                    'Priority Mail Return Service' => 'PRIORITY_MAIL_RETURN_SERVICE',
                ],
                'label_html' => true,
                'required' => true,
            ])
            ->add('processingCategory', ChoiceType::class, [
                'label' => 'Categoría de Procesamiento <span class="text-danger">*</span>',
                'choices' => [
                    'Letters' => 'LETTERS',
                    'Flats' => 'FLATS',
                    'Machinable' => 'MACHINABLE',
                    'Irregular' => 'IRREGULAR',
                    'Non Machinable' => 'NON_MACHINABLE',
                ],
                'label_html' => true,
                'required' => true,
            ])
            ->add('rateIndicator', ChoiceType::class, [
                'label' => 'Indicador de Tarifa <span class="text-danger">*</span>',
                'choices' => [
                    "3D - 3-Digit" => "3D",
                    "3N - 3-Digit Dimensional Rectangular" => "3N",
                    "3R - 3-Digit Dimensional Nonrectangular" => "3R",
                    "5D - 5-Digit" => "5D",
                    "BA - Basic" => "BA",
                    "BB - Mixed NDC" => "BB",
                    "BM - NDC" => "BM",
                    "C1 - Cubic Pricing Tier 1" => "C1",
                    "C2 - Cubic Pricing Tier 2" => "C2",
                    "C3 - Cubic Pricing Tier 3" => "C3",
                    "C4 - Cubic Pricing Tier 4" => "C4",
                    "C5 - Cubic Pricing Tier 5" => "C5",
                    "CP - Cubic Parcel" => "CP",
                    "CM - USPS Connect Local® Mail" => "CM",
                    "DC - NDC" => "DC",
                    "DE - SCF" => "DE",
                    "DF - 5-Digit" => "DF",
                    "DN - Dimensional Nonrectangular" => "DN",
                    "DR - Dimensional Rectangular" => "DR",
                    "E4 - Priority Mail Express Flat Rate Envelope - Post Office To Addressee" => "E4",
                    "E6 - Priority Mail Express Legal Flat Rate Envelope" => "E6",
                    "E7 - Priority Mail Express Legal Flat Rate Envelope Sunday / Holiday" => "E7",
                    "FA - Legal Flat Rate Envelope" => "FA",
                    "FB - Medium Flat Rate Box/Large Flat Rate Bag" => "FB",
                    "FE - Flat Rate Envelope" => "FE",
                    "FP - Padded Flat Rate Envelope" => "FP",
                    "FS - Small Flat Rate Box" => "FS",
                    "LC - USPS Connect® Local Single Piece" => "LC",
                    "LF - USPS Connect® Local Flat Rate Box" => "LF",
                    "LL - USPS Connect® Local Large Flat Rate Bag" => "LL",
                    "LO - USPS Connect® Local Oversized" => "LO",
                    "LS - USPS Connect® Local Small Flat Rate Bag" => "LS",
                    "NP - Non-Presorted" => "NP",
                    "O1 - Full Tray Box" => "O1",
                    "O2 - Half Tray Box" => "O2",
                    "O3 - EMM Tray Box" => "O3",
                    "O4 - Flat Tub Tray Box" => "O4",
                    "O5 - Surface Transported Pallet" => "O5",
                    "O6 - Full Pallet Box" => "O6",
                    "O7 - Half Pallet Box" => "O7",
                    "OS - Oversized" => "OS",
                    "P5 - Cubic Soft Pack Tier 1" => "P5",
                    "P6 - Cubic Soft Pack Tier 2" => "P6",
                    "P7 - Cubic Soft Pack Tier 3" => "P7",
                    "P8 - Cubic Soft Pack Tier 4" => "P8",
                    "P9 - Cubic Soft Pack Tier 5" => "P9",
                    "Q6 - Cubic Soft Pack Tier 6" => "Q6",
                    "Q7 - Cubic Soft Pack Tier 7" => "Q7",
                    "Q8 - Cubic Soft Pack Tier 8" => "Q8",
                    "Q9 - Cubic Soft Pack Tier 9" => "Q9",
                    "Q0 - Cubic Soft Pack Tier 10" => "Q0",
                    "PA - Priority Mail Express Single Piece" => "PA",
                    "PL - Large Flat Rate Box" => "PL",
                    "PM - Large Flat Rate Box APO/FPO/DPO" => "PM",
                    "PR - Presorted" => "PR",
                    "SB - Small Flat Rate Bag" => "SB",
                    "SN - SCF Dimensional Nonrectangular" => "SN",
                    "SP - Single Piece" => "SP",
                    "SR - SCF Dimensional Rectangular" => "SR",
                ],
                'label_html' => true,
                'required' => true,
            ])
            ->add('destinationEntryFacilityType', ChoiceType::class, [
                'label' => 'Tipo de Instalación de Entrada de Destino <span class="text-danger">*</span>',
                'choices' => [
                    'None' => 'NONE',
                    'Destination Network Distribution Center' => 'DESTINATION_NETWORK_DISTRIBUTION_CENTER',
                    'Destination Sectional Center Facility' => 'DESTINATION_SECTIONAL_CENTER_FACILITY',
                    'Destination Delivery Unit' => 'DESTINATION_DELIVERY_UNIT',
                    'Destination Service Hub' => 'DESTINATION_SERVICE_HUB',
                ],
                'label_html' => true,
                'required' => true,
            ])
            ->add('priceType', ChoiceType::class, [
                'label' => 'Tipo de Precio <span class="text-danger">*</span>',
                'choices' => [
                    'Retail' => 'RETAIL',
                    'Commercial' => 'COMMERCIAL',
                    'Contract' => 'CONTRACT',
                ],
                'label_html' => true,
                'required' => true,
            ])
            ->add('mailingDate', DateType::class, [
                'label' => 'Fecha de Envío',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('accountType', ChoiceType::class, [
                'label' => 'Tipo de Cuenta',
                'choices' => [
                    'EPS' => 'EPS',
                    'Permit' => 'PERMIT',
                    'Meter' => 'METER',
                ],
                'required' => false,
            ])
            ->add('accountNumber', TextType::class, [
                'label' => 'Número de Cuenta',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
