<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function sendEmail(MailerInterface $mailer, $appEmail)
    {
       $email = (new TemplatedEmail())
            ->from($appEmail)
            ->to(new Address('email@example.com', 'federico'))
            ->subject('Your order has been placed')
            ->htmlTemplate('email/index.html.twig')
        ;
        $mailer->send($email);
        return $this->render('email/VentanaEnviado.html.twig');
    }
}
