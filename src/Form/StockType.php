<?php

namespace App\Form;

use App\Entity\Size;
use App\Entity\Stock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType as ColorTypeSF;
use App\Entity\Color;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'label' => 'Quantité'
            ])
            ->add('color', EntityType::class, [
                'label' => 'Couleur',
                'class' => Color::class,
                'choice_label' => 'title'
            ])
            ->add('size', EntityType::class, [
                'label' => 'Taille',
                'class' => Size::class,
                'choice_label' => 'title'
            ])
            ->add('size', EntityType::class, [
                'label' => 'Taille',
                'class' => Size::class,
                'choice_label' => 'title'
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Activée',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
