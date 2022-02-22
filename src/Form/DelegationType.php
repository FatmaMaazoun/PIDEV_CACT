<?php

namespace App\Form;

use App\Entity\Delegation;
use App\Entity\Gouvernorat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DelegationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('gouvernorat', EntityType::class, [
                'class' => Gouvernorat::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Delegation::class,
        ]);
    }
}
