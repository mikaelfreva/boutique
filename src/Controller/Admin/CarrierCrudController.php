<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarrierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carrier::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextareaField::new('description'),
            MoneyField::new('price', 'prix')->setCurrency('EUR')->setCustomOption('storedAsCents', false),
        ];
    }

    // public function configureActions(Actions $actions): Actions
    // {
    //     $detail = Action::new('detailUser', 'detail', 'fa fa-user')
    //     ->linkToCrudAction(Crud::PAGE_DETAIL)
    //     ->addCssClass('btn btn-info');

        //return $actions
            // ...
            //->add(Crud::PAGE_INDEX, Action::DETAIL)
            //->add(Crud::PAGE_INDEX, $detail)
            
            //->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
           
   // }
}
