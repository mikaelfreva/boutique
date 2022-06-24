<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;
    protected $productRepository;


    public function __construct(RequestStack $session, ProductRepository $productRepository)
    {
        $this->session = $session->getSession();
        $this->productRepository = $productRepository;
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


        $this->session->set('panier', $panier);
    }



    public function get(){
        return $this->session->get('panier');
    }

    public function remove(){
        return $this->session->remove('panier');
    }

    public function delete($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function decrease($id)
    {
        // On récupère le panier actuel
        $panier = $this->session->get("panier", []);
      
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
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
        if($this->get()){
            foreach ($this->get() as $id => $quantity) {

                $productObject = $this->productRepository->find($id);

                if(!$productObject){
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







}

