<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository)
    {
        $this->entityManager = $entityManager;
        $this->orderRepo = $orderRepository;
    }


    #[Route('/compte/mes-commandes', name: 'account_order')]
    public function index(): Response
    {
        $orders = $this->orderRepo->findSuccessOrder($this->getUser());
     
        return $this->render('account/order.html.twig',[
            'orders' => $orders
        ]);
    }


    #[Route('/compte/mes-commandes/{reference}', name: 'account_order_show')]
    public function show($reference): Response
    {
        $order = $this->orderRepo->findOneByReference($reference);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_order');
        }
     
        return $this->render('account/order_show.html.twig',[
            'order' => $order
        ]);
    }


}
