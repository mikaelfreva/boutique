<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\FormPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureActions(Actions $actions): Actions
    {

        
       
        $updatePreparation = Action::new('updateUserr', 'Retirer son admin','fas fa-truck')
            ->linkToCrudAction('updateUserr')
            ->displayIf(static function ($entity) {
                return  $entity->getRoles() == ["ROLE_USER"]
                ;
            })
            ;

        $updateDelivery= Action::new('updateUser', 'Définir comme administrateur','fas fa-truck')
            ->linkToCrudAction('updateUser')
            ->displayIf(static function ($entity) {
                //dd($entity->getRoles());
                return $entity->getRoles() == ["ROLE_USER"]
                ;
            })
         ;


        return $actions
            ->add('index', 'detail')
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_SUPER_ADMIN')
            ;
    }


    
    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('email')
            ->setFormTypeOptions([
                'disabled' => true
            ]),
            TextField::new('password')->onlyWhenCreating(),
          
            ChoiceField::new('roles', 'Roles')->onlyOnIndex()
            ->setChoices([  'User' => 'ROLE_USER',
            'Admin' => 'ROLE_ADMIN',
             'Super Admin' => 'ROLE_SUPER_ADMIN'
            ])
            ,

            ChoiceField::new('roles', 'Roles')->onlyWhenCreating()->onlyWhenUpdating()
            ->allowMultipleChoices()
            ->setPermission('ROLE_SUPER_ADMIN')
            ->setChoices([  'User' => 'ROLE_USER',
                            'Admin' => 'ROLE_ADMIN',
                             'Super Admin' => 'ROLE_SUPER_ADMIN'
                            ]
        ),

        


        // ChoiceField::new('roles')
        //     ->setChoices(array_combine($roles, $roles))
        //     ->allowMultipleChoices()
        //     ->renderExpanded()
        ];
    }
    
}
