<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\DemandeEvenement;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire')
            ->add('note', RangeType::class, [
        'attr' => [
            'min' => 5,
            'max' => 50]
    ])
            ->add('demandeEvent',EntityType::class, [
                'class' => DemandeEvenement::class,
                'choice_label' => 'statut',
                'expanded' => false,
                'multiple' => false ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false ]);


    }


}
