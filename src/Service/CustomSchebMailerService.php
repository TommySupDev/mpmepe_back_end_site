<?php

namespace App\Service;

use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;

class CustomSchebMailerService implements AuthCodeMailerInterface
{
    public function __construct(
        private EmailSmsServices $emailSmsServices
    )
    {
    }

    public function sendAuthCode(TwoFactorInterface $user): void
    {
        $authCode = $user->getEmailAuthCode();

        $data = [
            'emailFrom' => "solutechcorporate@gmail.com",
            'fromName' => "Automatic Emails",
            'authCode' => $authCode,
        ];

        // Send email
        $this->emailSmsServices->sendEmail(
            $user->getEmailAuthRecipient(),
            'email_templates/scheb_auth_code.html.twig',
            "Code d'authentification à double facteurs",
            $data['emailFrom'],
            $data['fromName'],
            $data
        );
    }

}
