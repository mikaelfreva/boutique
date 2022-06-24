<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Service\Cart\CartService;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class OrderSuccessController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_validate')]
    public function index($stripeSessionId, CartService $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        $order_detail = $this->entityManager->getRepository(OrderDetails::class)->findByMyOrder($order->getId());


        $return = '';

        foreach ($order_detail as $order_element) {

            $return .= '
            <li>' . $order_element->getProduct() . ', x' . $order_element->getQuantity() . '</li>';
        }

        $content = "Bonjour " . $order->getUser()->getEmail() . "<br/>Merci pour votre commande. <br>Vos article sont:<br><ul>" . $return . "</ul>.";


        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        if ($order->getState() == 0) {
            $cart->remove();
            $order->setState(1);
            $this->entityManager->flush();
            $mail = new Mail();

            $mail->send($order->getUser()->getEmail(), $order->getUser()->getEmail(), 'Votre commande La Boutique Française est bien validée.', $content);
        }
        //dd($order);
        return $this->render('order/order.success.html.twig', [
            'order' => $order
        ]);
    }
}
