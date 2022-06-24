<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, AddressRepository $addressRepository)
    {
        $this->entityManager = $entityManager;
        $this->addressRepo = $addressRepository;
    }

    


    #[Route('/compte/addresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }


    #[Route('/compte/ajout-adresse', name: 'account_address_add')]
    public function add(Request $request, CartService $cart): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            if($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('account_address');
            }
            
        }

        return $this->render('account/address.add.html.twig',[
            'form' => $form->createView()
        ]);
    }


    #[Route('/compte/modifier-adresse/{id}', name: 'account_address_edit')]
    public function edit(Request $request, $id): Response
    {
        $address = $this->addressRepo->findOneByid($id);

        if(!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address.add.html.twig',[
            'form' => $form->createView()
        ]);
    }



    #[Route('/compte/delete-adresse/{id}', name: 'account_address_delete')]
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneByid($id);

        if($address && $address->getUser() == $this->getUser()){
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }
  
        return $this->redirectToRoute('account_address');
   
     
    }
}
