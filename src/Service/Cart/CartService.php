<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;

class CartService
{

    protected $session;
    protected $productRepository;


    public function __construct(RequestStack $session, ProductRepository $productRepository, EntityManagerInterface $em)
    {
        $this->session = $session->getSession();
        $this->productRepository = $productRepository;
        $this->em = $em;
    }



    public function add(int $id)
    {

        //$session = $request->getSession();
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }


        $product_add = $this->productRepository->findOneById($id)->getName();
       // $this->session->getFlashBag()->add('success', 'Une quantité ajouté pour : ' . $product_add . '');


        $this->session->set('panier', $panier);
     
    }



    public function get()
    {
        return $this->session->get('panier');
    }

    public function remove()
    {
        return $this->session->remove('panier');
    }

    public function delete($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
        //$this->session->getFlashBag()->add('danger', 'Produit supprimé');
    }

    public function decrease($id)
    {
        // On récupère le panier actuel
        $panier = $this->session->get("panier", []);

        $product_decrease = $this->productRepository->findOneById($id)->getName();
        //$this->session->getFlashBag()->add('danger', 'Une quantité supprimé pour : ' . $product_decrease . '');


        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        return $this->session->set("panier", $panier);
    }



    public function getFullcart()
    {

        //$panier = $this->session->get('panier', []);
        $cartComplete = [];
        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {

                $productObject = $this->productRepository->find($id);

                if (!$productObject) {
                    $this->delete($id);
                    continue;
                }


                $cartComplete[] = [
                    'product' => $productObject,
                    'quantity' => $quantity
                ];
            }
        }


        return $cartComplete;
    }

    public function getTotal(): float
    {
        $total = 0;
        $panierWithData = $this->getFullcart();

        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;
    }


    public function GetNameByIdInAction($id)
    {
       return strtolower($this->productRepository->findOneById($id)->getName());
    }
}
