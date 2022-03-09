<?php

namespace App\Form;

use App\Entity\destinationSearch;
use App\Entity\Gouvernorat;
use App\Entity\SousCategorie;
use Doctrine\DBAL\Types\IntegerType as TypesIntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DestinationSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, ['required' => false])
            ->add('prix', IntegerType::class, [
                'required' => false,
                'label' => 'Budget'
            ])
            ->add('gouvernorat', EntityType::class, [
                'class' => Gouvernorat::class,
                'choice_label' => 'nom',
                'required' => false,

                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => destinationSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
