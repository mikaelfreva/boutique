<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{


    #[Route('/panier', name: 'app_cart')]
    public function index(CartService $cartService, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findByIsBest(1);
    
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullcart(),
            'total' => $cartService->getTotal(),
            'products' => $products
        ]);
    }



    #[Route('/panier/add/{id}', name: 'add_to_cart')]
    public function add($id, CartService $cartService): Response
    {
        $cartService->add($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/panier/decrease/{id}', name: 'cart_decrease')]
    public function decrease($id, CartService $cartService)
    {
       
        $cartService->decrease($id);
        return $this->redirectToRoute('app_cart');


    }


    #[Route('/panier/delete/{id}', name: 'cart_delete')]
    public function delete($id, CartService $cartService)
    {

        $cartService->delete($id);
        return $this->redirectToRoute('app_cart');
    }



    #[Route('/panier/remove/', name: 'cart_delete_all')]
    public function removeAll(CartService $cartService)
    {
        $cartService->remove();
        // $session->remove("panier");

        return $this->redirectToRoute("app_cart");
    }
}

