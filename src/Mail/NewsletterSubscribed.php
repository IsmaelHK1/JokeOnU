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
    }
}
