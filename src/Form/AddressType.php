<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'addresse',
                'choices' => [
                    'Livraison' => Address::DELIVERY,
                    'Facturation' => Address::BILLING
                ]
            ])
            ->add('number', TextType::class, [
                'label' => 'N°'
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('zip', TextType::class, [
                'label' => 'Code postal'
            ])
            ->add('selected', CheckboxType::class, [
                'required' => false,
                'label' => 'Choisir cette adresse par défaut ?'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
