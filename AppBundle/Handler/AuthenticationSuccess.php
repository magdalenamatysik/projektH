<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016-10-24
 * Time: 23:59
 */

namespace AppBundle\Handler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
    protected $authorizationChecker;
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router,  AuthorizationChecker $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }
    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $redirection = new RedirectResponse($this->router->generate('userPanel'));
        return $redirection;
    }
}