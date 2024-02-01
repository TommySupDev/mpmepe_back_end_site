<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class TwoFactorAuthenticationSuccessHandler extends AuthenticationSuccessHandler
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        // Return the response to tell the client that authentication including two-factor
        // authentication is complete now.
//        return new Response('{"login": "success", "two_factor_complete": true}');
        return $this->handleAuthenticationSuccess($token->getUser());
    }
}
