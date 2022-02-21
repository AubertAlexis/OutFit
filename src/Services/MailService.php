<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailService
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var Environment
     */
    private Environment $templating;

    /**
     * @param MailerInterface $mailer
     * @param Environment $templating
     */
    public function __construct(MailerInterface $mailer, Environment $templating){
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * Send a Mail
     *
     * @param string $mailTo
     * @param string $subject
     * @param string $text
     * @param string $viewPath
     * @param array $options
     */
    public function sendEmail(string $mailTo, string $subject, string $viewPath, array $options)
    {
        $email = (new Email())
            ->to($mailTo)
            ->subject($subject)
            ->html(
                $this->templating->render(
                    $viewPath,
                    $options
                ), 'text/html'
            );

        $this->mailer->send($email);
    }
}