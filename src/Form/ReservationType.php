<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_res')
            ->add('heure_res')
            ->add('statut',ChoiceType::class,
                ['required'=>true,
                    'multiple'=>false,
                    'expanded'=>false,
                    'choices'=>[
                        'En attente'=>'En attente',
                        'Cloturée'=>'Cloturée',
                        'Annulée'=>'Annulée',]
                ])
            ->add('cout')
            ->add('demandeEvent')
            ->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
