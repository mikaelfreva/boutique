<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TypeTextType::class,[
            'label' => 'Prénom',
            'attr' => [
                'placeholder' => 'Merci de saisir votre prénom'
            ]
        ])
        ->add('lastname', TypeTextType::class,[
            'label' => 'Nom',
            'attr' => [
                'placeholder' => 'Merci de saisir votre nom'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Mail',
            'constraints' => new Length([
                'min' => 2,
                'max' => 60
            ]),
            'attr' => [
                'placeholder' => 'Merci de saisir votre mail'
            ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Saisissez le mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer le mot de passe'
                    ]
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
