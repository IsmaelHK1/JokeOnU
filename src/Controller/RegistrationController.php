<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Joke;
use Blagues\BlaguesApi;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Mail\NewsletterSubscribed;
use DateTime;
use Symfony\Component\Mime\Email;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, MailerInterface $mailer,): Response
    {
        $blaguesApi = new BlaguesApi($_ENV['TOKEN']);

        $jokes = $blaguesApi->getRandom();

        $blague = new joke();
        $blague->setKeyApi($jokes->getId());
        $entityManager->persist($blague);
        $entityManager->flush();
        $blague->getId();

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEmail($form->get('email')->getData())
                ->setRoles(['ROLE_USER'])
                ->setJoke($blague);
            $entityManager->persist($user);
            $entityManager->flush();

            //NEWSLETTER
            $newsletter = new Newsletter();
            $newsletter->setCreated(new DateTime());
            $newsletter->setEmail($form->get('email')->getData());
            $entityManager->persist($newsletter);
            $entityManager->flush();
            $email = (new Email())
                ->from("noreply@jokeonu.com")
                ->to($newsletter->getEmail())
                ->subject("Inscription à la newsletter")
                ->text("Votre email " . $newsletter->getEmail() . " a bien été enregistré, merci");
            $mailer->send($email);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
