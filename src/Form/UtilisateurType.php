<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login')
            ->add('password')
            ->add('role',ChoiceType::class,
            ['required'=>true,
            'multiple'=>false,
            'expanded'=>false,
            'choices'=>[
                'Admin'=>'ROLE_ADMIN',
                'Client'=>'ROLE_CLIENT',
                'Partenaire'=>'ROLE_PARTENAIRE',]
            ])
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance')
            ->add('email')
            ->add('num_tel')
            ->add('enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
