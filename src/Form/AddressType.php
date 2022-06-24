<?php

namespace App\Form;

use App\Entity\Address;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                'label' => 'Quel nom souhaitez vous donner à votre adresse',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname', TypeTextType::class, [
                'label' => "Votre prénom",
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TypeTextType::class, [
                'label' => "Votre nom",
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('company', TypeTextType::class, [
                'label' => "Votre société",
                'required' => false,
                'attr' => [
                    'placeholder' => '(facultatif) Entrez votre société'
                ]
            ])
            ->add('address', TypeTextType::class, [
                'label' => "Votre adresse",
                'attr' => [
                    'placeholder' => '8 rue des taureaux'
                ]
            ])
            ->add('postal', TypeTextType::class, [
                'label' => "Votre code postal",
                'attr' => [
                    'placeholder' => 'Entrez votre code postal'
                ]
            ])
            ->add('city', TypeTextType::class, [
                'label' => "Votre ville",
                'attr' => [
                    'placeholder' => 'Nommez votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Votre pays",
                'attr' => [
                    'placeholder' => 'Votre pays',
                    'class' => 'form-control'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "Votre téléphone",
                'attr' => [
                    'placeholder' => 'Votre téléphone',
                   
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
