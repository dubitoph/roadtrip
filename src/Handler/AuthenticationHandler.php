<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class AuthenticationHandler implements AuthenticationFailureHandlerInterface, LogoutSuccessHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $router) 
    {

        $this->router = $router;
        
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    { 

        $session = $request->getSession();
        
        $referer = $request->headers->get('referer');       
        $session->getFlashBag()->add('error', $exception->getMessage());
        $session->set('errorFomAuthentication', true);

        return new RedirectResponse($referer);

    }

    public function onLogoutSuccess(Request $request) 
    {

        return new RedirectResponse($this->router->generate('home'));

    }

}