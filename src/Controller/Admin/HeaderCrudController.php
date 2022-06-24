<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('title', 'Titre du header'),
           TextareaField::new('content', 'Contenu du header'),
           TextField::new('btnTitle', 'Titre du bouton'),
           TextField::new('btnUrl', 'Url du bouton'),
           ImageField::new('illustration', 'Photo')
                ->setBasePath('assets/uploads/img/header')
                ->setUploadDir('public/assets/uploads/img/header')
                ->setUploadedFileNamePattern('[uuid]-[randomhash].[extension]')
                ->setFormTypeOptions([
                    'mapped' => true, 
                    'required' => false,
                    'by_reference' => false
                    ])
                ->setRequired(false),
        ];
    }
    
}
