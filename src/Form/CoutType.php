<?php

namespace App\Form;

use App\Entity\Cout;
use App\Entity\CoutCategorie;
use App\Entity\Destination;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('destination', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('coutcategorie', EntityType::class, [
                'class' => CoutCategorie::class,
                'choice_label' => 'libelle',
                'expanded' => false,
                'multiple' => false
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cout::class,
        ]);
    }
}
