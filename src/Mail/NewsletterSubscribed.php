<?php

namespace App\Mail;

use Symfony\Component\Mailer\MailerInterface;
use App\Entity\Newsletter;
use Symfony\Component\Mime\Email;

class NewsletterSubscribed
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmation(Newsletter $newsletter)
    {
        $email = (new Email())
            ->from("noreply@jokeonu.com")
            ->to($newsletter->getEmail())
            ->subject("Inscription à la newsletter")
            ->text("Votre email " . $newsletter->getEmail() . " a bien été enregistré, merci");
        $this->mailer->send($email);
    }
}
