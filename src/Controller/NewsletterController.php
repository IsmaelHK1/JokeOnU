<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Mail\NewsletterSubscribed;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class NewsletterController extends AbstractController
{
    #[Route('/newsletter/register', name: 'app_newsletter')]

    public function register(
        Request $request,
        EntityManagerInterface $em,
        NewsletterSubscribed $newsletters,
        MailerInterface $mailer
    ): Response {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter->setCreated(new DateTime());
            $em->persist($newsletter);
            $em->flush();
            $email = (new Email())
                ->from("noreply@jokeonu.com")
                ->to($newsletter->getEmail())
                ->subject("Inscription à la newsletter")
                ->text("Votre email " . $newsletter->getEmail() . " a bien été enregistré, merci");
            $mailer->send($email);
            return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('newsletter/test.html.twig', [
            'form' => $form
        ]);
    }
}
