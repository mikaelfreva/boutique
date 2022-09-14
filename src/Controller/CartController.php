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

    private $productRepository;
    private $cartService;

    public function __construct(ProductRepository $productRepository, CartService $cartService )
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }
//panier
    #[Route('/panier', name: 'app_cart')]
    public function index(): Response
    {
        $products = $this->productRepository->findByIsBest(1);
    
        return $this->render('cart/index.html.twig', [
            'items' => $this->cartService->getFullcart(),
            'total' => $this->cartService->getTotal(),
            'products' => $products
        ]);
    }



    #[Route('/panier/add/{id}', name: 'add_to_cart')]
    public function add($id): Response
    {
        $this->cartService->add($id);

        //$p = $this->productRepository->findOneById($id)->getName();
        $this->addFlash('success', $this->cartService->GetNameByIdInAction($id) .' est ajouté au panier');
        return $this->redirectToRoute('app_cart');

        
    }

    #[Route('/panier/decrease/{id}', name: 'cart_decrease')]
    public function decrease($id)
    {
      
        $this->cartService->decrease($id);
        $this->addFlash('danger', '1 ' . $this->cartService->GetNameByIdInAction($id) . ' retiré du panier');

        return $this->redirectToRoute('app_cart');

       
    }



    #[Route('/panier/delete/{id}', name: 'cart_delete')]
    public function delete($id)
    {

        $this->cartService->delete($id);
        return $this->redirectToRoute('app_cart');
        $this->addFlash('notice','Panier mis à jour');
    }



    #[Route('/panier/remove/', name: 'cart_delete_all')]
    public function removeAll()
    {
        $this->cartService->remove();
        // $session->remove("panier");

        return $this->redirectToRoute("app_cart");
    }
}

