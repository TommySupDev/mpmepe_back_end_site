<?php

namespace App\Security;

use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorTokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class JWTAuthenticationSuccessHandler extends AuthenticationSuccessHandler
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        if ($token instanceof TwoFactorTokenInterface) {
            // Return the response to tell the client two-factor authentication is required.
            return new Response('{"login": "success", "two_factor_complete": false, "success": false, "message": "Complete 2FA Verification to proceed", "code": 410}');
        }

        // Otherwise return the default response for successful login. You could do this by decorating
        // the original authentication success handler and calling it here.
        return $this->handleAuthenticationSuccess($token->getUser());
    }
}
