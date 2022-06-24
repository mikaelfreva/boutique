<?php

namespace App\Controller;

use App\Entity\Header;
use App\Entity\Product;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;
    private $cart;

    public function __construct(EntityManagerInterface $entityManager, CartService $cart)
    {
        $this->entityManager = $entityManager;
        $this->cart = $cart;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {

        $carts = $this->cart->get('panier');
        //dd($carts);

        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();
        // $mail = new Mail();
        // $mail->send('mikefreva@gmail.com', 'Mike Doe','Mon mail test','Bonjour, ceci est un mail test');
        return $this->render('home/index.html.twig',[
            'products' => $products,
            'headers' => $headers
        ]);
    }
}
