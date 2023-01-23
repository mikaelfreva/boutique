<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Service\Mail;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/mot-de-passe-oublie', name: 'app_reset_password')]
    public function index(Request $request): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));

            if ($user) {
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                //$reset_password->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
                $reset_password->setCreatedAt(new DateTimeImmutable);
              
                
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();



                $url = $this->generateUrl('update_password', [
                    'token' => $reset_password->GetToken()
                ]);

                $content = "Bonjour " . $user->getEmail() . "<br> Vous avez demandé à réinitialiser votre mot de passe <br><br>";
                $content .= "Merci de cliquez sur le lien suivant <a href='https:commerce.mikaelfreva.com" . $url . "'>Mettre a jour le mot de passe</a>";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getEmail(), "Réinitialisez mot de passe", $content);

                $this->addFlash('notice','Vous allez recevoir un mail ');
            }else{
                $this->addFlash('notice','Adresse mail inconnu');
            }
        }

        return $this->render('reset_password/index.html.twig');
    }




    #[Route('modifier-mot-de-passe/{token}', name: 'update_password')]
    public function update($token, Request $request, UserPasswordHasherInterface $encoder)
    {

        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);


        if (!$reset_password) {
            return $this->redirectToRoute('app_reset_password');
        }

        //$now = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
        $now = new DateTimeImmutable('now');

        if($now > $reset_password->getCreatedAt()->modify('+ 3 hour') ){
            $this->addFlash('notice','Votre demande de réinitialisation à expiré');
            return $this->redirectToRoute('app_reset_password');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $new_password = $form->get('new_password')->getData();
            $password = $encoder->hashPassword($reset_password->getUser(), $new_password);
            $reset_password->getUser()->setPassword($password);
         
            $this->entityManager->flush();

            $this->addFlash('notice','Votre mot de passe à été mis a jour');
            return $this->redirectToRoute('login');
        }
        return $this->render('reset_password/update.html.twig',[
            'form' => $form->createView()
        ]);
        // dump($now);
        // dump($reset_password->getCreatedAt()->modify('+ 3 hour'));
         //dd($reset_password);
        



    }
}
