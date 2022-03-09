<?php

namespace App\Form;
use App\Entity\Destination;
use App\Entity\DemandeEvenement;
use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DemandeEvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('destination',EntityType::class,[
            'class'=>Destination::class,
            'choice_label'=>'nom',
            
        ])
      
            ->add('libelleEvenement')
            ->add('date_demande',DateTimeType::class,['date_widget'=>'single_text'])
            ->add('description_demande',TextareaType::class)
            ->add('date_debutEvent',DateTimeType::class,['date_widget'=>'single_text'])
            ->add('date_finEvent',DateTimeType::class,['date_widget'=>'single_text'])
            ->add('heure_debutEvent')
            ->add('heure_finEvent')
            ->add('description_event',TextareaType::class)
            ->add('capacite')
            ->add('image', FileType::class,array('data_class' => null))
            ->add('utilisateur',EntityType::class,[
                'class'=>Utilisateur::class,
                'choice_label'=>'nom',
                
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeEvenement::class,
        ]);
    }
}
