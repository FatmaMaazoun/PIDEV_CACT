<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('description')
            ->add('date_rec')
            ->add('reservation',EntityType::class,[
                'class'=>Reservation::class,
                'choice_label'=>'id',
            ])
            ->add('enregistrer',SubmitType::class)
        ;
    }


}
