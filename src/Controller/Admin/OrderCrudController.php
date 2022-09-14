<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {


        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours','fas fa-truck')
            ->linkToCrudAction('updatePreparation')
            ->displayIf(static function ($entity) {
                return $entity->getState() == 1 
                ;
            });

        $updateDelivery= Action::new('updateDelivery', 'Livraison en cours','fas fa-truck')
            ->linkToCrudAction('updateDelivery')
            ->displayIf(static function ($entity) {
                return $entity->getState() == 2;
            })
         ;


        return $actions
            ->add('index', 'detail')
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE);
    }

    public function updatePreparation(AdminContext $context)
    {

        $order = $context->getEntity()->getInstance();
       
        if ($order->getState() != 2) {
            $order->setState(2);
            $this->entityManager->flush();

            $this->addFlash('notice', "<span style='color:green'> <strong>La commande " . $order->getReference() . " est bien en cours de préparation</strong> </span>");
        }

        $mail = new Mail();
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getEmail(), 'Votre commande est bien en préparation.', 'Votre commande est en préparation');

        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('detail')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context)
    {

        $order = $context->getEntity()->getInstance();
        //dd($order);
        if ($order->getState() != 3) {
            $order->setState(3);
            $this->entityManager->flush();

            $this->addFlash('notice', "<span style='color:blue'> <strong>La commande " . $order->getReference() . " est bien en cours de livraison</strong> </span>");
        }


        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('detail')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id'),
            DateTimeField::new('createAt', 'Passé le'),
            TextField::new('user.email', 'Mail du consommateur'),
            TextareaField::new('delivery','Adresse de livraison')->onlyOnDetail()->renderAsHtml(),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('total')->setCurrency('EUR')->setCustomOption('storedAsCents', false),
            MoneyField::new('carrierPrice', 'Prix de livraison')->setCurrency('EUR')->setCustomOption('storedAsCents', false),
            ChoiceField::new('state')->setChoices([
                'Non payé' => 0,
                'Payé' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3
            ]),
            ArrayField::new('orderDetails')->hideOnIndex()
        ];
    }
}
