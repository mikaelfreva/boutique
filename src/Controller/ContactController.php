<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
     

        if ($form->isSubmitted() && $form->isValid()) {
           
            $nom = $form->get('nom')->getData();
            $prenom = $form->get('prenom')->getData();
            $email = $form->get('email')->getData();
            $content = $form->get('content')->getData();
            $message = "<h2>Ceci provient du formulaire de contact du site de la boutique.</h2> Nom : ". $nom . "<br> Prénom : ". $prenom . "<br> Message : ". $content . ".";
         
            $mail = new Mail();
            $mail->send('mikefreva@gmail.com', $email, "Formulaire contact", $message);

         
            $this->addFlash('notice','Merci de nous avoir contacté');

           
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
