<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Service\Cart\CartService;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'order')]
    public function index(CartService $cartService): Response
    {

        //coucou
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cartService->getFullcart(),
        ]);
    }


    #[Route("/commande/recapitulatif", name: "order_recap", methods: "POST")]
    public function add(CartService $cartService, Request $request): Response
    {

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date_time = new DateTimeImmutable();
            $date = $date_time->setTimezone(new DateTimeZone('Europe/Paris'));


            $carrier = $form->get('carrier')->getData();
         
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            $delivery_content .= '<br/>' . $delivery->getPhone();
            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>' . $delivery->getCompany();
            }

            $delivery_content .= '<br/>' . $delivery->getAddress();
            $delivery_content .= '<br/>' . $delivery->getPostal() . ' ' . $delivery->getCity();
            $delivery_content .= '<br/>' . $delivery->getCountry();
            //dd($delivery_content);


            $order = new Order();
            $reference = $date->format('dmY').'-'. uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreateAt($date);
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->entityManager->persist($order);

            foreach ($cartService->getFullCart() as $product) {

                //dd($product);
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($orderDetails);



            }
           

            $this->entityManager->flush();


            Stripe::setApiKey('sk_test_51L9xbcACvbzkZacVNqXaOvMSNpjGxugLghCygDTRo6g08AYbcox5LMAwxRwfGa2yMfoSRnyh49py7me891rPzQP3009YcF29UC');

           

            return $this->render('order/add.html.twig', [
                'cart' => $cartService->getFullcart(),
                'carrier' => $carrier,
                'delivery' => $delivery_content,
                'reference' => $order->getReference()
    
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }
}
