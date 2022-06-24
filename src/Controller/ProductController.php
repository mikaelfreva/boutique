<?php

namespace App\Controller;

use App\Service\Search;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form;
use App\Form\SearchType;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{



    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/produits', name: 'app_product')]

    public function index(Request $request, ProductRepository $productRepository): Response
    {

        $products = $productRepository->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productRepository->findWithSearch($search);
        }
        else{
            $products = $productRepository->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }



    #[Route('/produit/{slug}', name: 'product')]

    public function show($slug, ProductRepository $productRepository): Response
    {

        $product = $productRepository->findOneBySlug($slug);

        $products = $productRepository->findByIsBest(1);
    

        if(!$product){
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products
        ]);
    }


}
