<?php

namespace App\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TypeTextType::class,[
                'label' => "Votre prénom",
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])

            ->add('nom', TypeTextType::class,[
                'label' => "Votre nom",
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])


            ->add('email', EmailType::class, [
                'label' => 'Mon adresse mail',
                'attr' => [
                    'placeholder' => 'Votre mail'
                ]
            ])

            ->add('content', TextareaType::class,[
                'label' => "Votre message",
                'attr' => [
                    'placeholder' => 'Votre message'
                ]
            ])


            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => 'btn-block btn-success'
                ]

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
