<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [

            TextField::new('name', 'Nom'),
            SlugField::new('slug', 'URL')->setTargetFieldName('name'),
            AssociationField::new('category', 'Catégorie'),
            ImageField::new('illustration', 'Photo')
                ->setBasePath('assets/uploads/img')
                ->setUploadDir('public/assets/uploads/img')
                ->setRequired(false)
                ->setUploadedFileNamePattern('[uuid]-[randomhash].[extension]')
                ->setFormTypeOptions([
                    'mapped' => true, 
                    'required' => false,
                    'by_reference' => false
                    ])
                ->setRequired(false),
           
     

    

            // ImageField::new('video', 'Vidéo')
            //     ->setBasePath('assets/uploads/video')
            //     ->setUploadDir('public/assets/uploads/video')
            //     ->addCssFiles('assets/admin/admin.css')
            //     ->addJsFiles('assets/admin/jquery.js')
            //     ->addJsFiles('assets/admin/admin.js')
            //     ->setUploadedFileNamePattern('[randomhash].[extension]'),
            BooleanField::new('isBest', 'Best'),
            TextField::new('subtitle', 'Sous Titre'),
            TextareaField::new('description', 'Description'),
            MoneyField::new('price')->setCurrency('EUR'),
       

        ];





    }


}
