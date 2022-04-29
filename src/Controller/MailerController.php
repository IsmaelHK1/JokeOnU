<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(): Response
    {
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from("admin@ynov-corp.com")
            ->to($newsletter->getEmail())
            ->subject("Inscription à la newsletter")
            ->text("Votre email " . $newsletter->getEmail() . " a bien été enregistré, merci");

        $mailer->send($email);

        // ...
    }
}
