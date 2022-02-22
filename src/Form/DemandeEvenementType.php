<?php

namespace App\Form;
use App\Entity\Destination;
use App\Entity\DemandeEvenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DemandeEvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('destination',EntityType::class,[
            'class'=>Destination::class,
            'choice_label'=>'libelle',
            
        ])
            ->add('date_demande')
            ->add('statut')
            ->add('description_demande')
            ->add('date_debutEvent')
            ->add('date_finEvent')
            ->add('heure_debutEvent')
            ->add('heure_finEvent')
            ->add('description_event')
            ->add('capacite')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeEvenement::class,
        ]);
    }
}
