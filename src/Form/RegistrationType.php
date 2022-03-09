<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login')
            ->add('password',PasswordType::class)
            ->add('confirm_password',PasswordType::class)
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
            ->add('Conditions',CheckboxType::class,[
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter vos conditions'
                    ]),
                ],
            ])
            ->add('capatchaCode' , CaptchaType::class,[
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Captcha invalide, merci de réessayer'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
