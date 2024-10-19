<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Enter city name',
                ]
            ])
            ->add('countryCode', ChoiceType::class, [
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Norway' => 'NO',
                ],

            ])
            ->add('latitude', NumberType::class, [
                'input' => 'string',
                'scale' => 6,
            ])
            ->add('longitude', NumberType::class, [
                'input' => 'string',
                'scale' => 6,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
