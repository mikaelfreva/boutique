<?php

namespace App\Controller;

use App\Controller\Admin\CarrierCrudController;
use App\Entity\Carrier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    
    // private $adminUrlGenerator;

    // public function __construct(AdminUrlGenerator $adminUrlGenerator)
    // {
    //     $this->adminUrlGenerator = $adminUrlGenerator;
    // }

    #[Route('/compte', name: 'account')]
    public function index(): Response
    {
        // $url = $this->adminUrlGenerator
        // ->setController(CarrierCrudController::class)
        // ->setAction(Action::INDEX)
        // ->generateUrl();
      
        
    //dd($url);
    //return $this->redirect($url);


        return $this->render('account/index.html.twig');
    }
}
