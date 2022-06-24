<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
   

    #[Route('/commande/create-session/{reference}', name: 'stripe-create-session')]
    public function index(CartService $cartService, $reference, EntityManagerInterface $entityManager): Response
    {
   

        header('Content-Type: application/json');

        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);
       
        if(!$order){
            new JsonResponse(['error' => 'order']);
        }

        //dd($order->getOrderDetails()->getValues());

        foreach ($order->getOrderDetails()->getValues() as $product) {
           $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN . "/public/assets/uploads/img/" . $product_object->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => ($order->getCarrierPrice()*100),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];

  


        Stripe::setApiKey('sk_test_51L9xbcACvbzkZacVNqXaOvMSNpjGxugLghCygDTRo6g08AYbcox5LMAwxRwfGa2yMfoSRnyh49py7me891rPzQP3009YcF29UC');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),

            'payment_method_types' => ['card'],
            'line_items' => [[
                $product_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
        
        $order->setStripeSessionId($checkout_session->id);

        $entityManager->flush();

        //$response = new JsonResponse(['id' => $checkout_session->id]);
        //return $response;

        return $this->redirect($checkout_session->url);


        //return $this->render('stripe/index.html.twig');


    }
}
