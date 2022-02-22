<?php

namespace App\Form;
use App\Entity\CoutCategorie;
use App\Entity\DemandeEvenement;
use App\Entity\CoutEvenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoutEvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NbBillet')
            ->add('prix')
            ->add('coutcategorie',EntityType::class,[
                'class'=>CoutCategorie::class,
                'choice_label'=>'libelle',
                
            ])
            ->add('demandeEvent',EntityType::class,[
                'class'=>DemandeEvenement::class,
                'choice_label'=>'description_event',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CoutEvenement::class,
        ]);
    }
}
