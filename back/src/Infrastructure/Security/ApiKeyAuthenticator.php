<?php

namespace  SymplBundle\Security\GuardAuthenticator;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use SymplBundle\DataManager\ApiTokenManager\ApiTokenManager;
use SymplBundle\Security\AnonymousUser;
use SymplBundle\TokenFormatter\Exception\BadJwtException;
use SymplBundle\TokenFormatter\Formatter\JwtFormatter;

class ApiKeyAuthenticator extends  AbstractGuardAuthenticator
{
    /** @var ApiTokenManager */
    private $apiTokenManager;

    /** @var JwtFormatter */
    private $jwtFormatter;

    /**@var TokenStorageInterface */
    private $tokenStorage;

    /** @var AuthenticationManagerInterface */
    private $authenticationManager;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    const AUTH_TOKEN_NOT_FOUND = 1;

    public function __construct(
        ApiTokenManager $apiTokenManager,
        JwtFormatter $jwtFormatter,
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager,
        EventDispatcherInterface $dispatcher
    ) {
        $this->apiTokenManager = $apiTokenManager;
        $this->jwtFormatter = $jwtFormatter;
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        return [
            'token' => $request->headers->get('X-Emailing-App-Authorization'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $jwt =  $apiToken = $credentials['token'];

        if ($jwt) {
            try {
                $jwtToken = $this->jwtFormatter->getTokenFromJwt($jwt);

                return $this->apiTokenManager->getUserByToken($jwtToken);

            } catch (BadJwtException $e) {
                throw new AuthenticationException('', self::AUTH_TOKEN_NOT_FOUND);
            }
        }

        return new AnonymousUser();
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $authToken = $this->authenticationManager->authenticate($token);
        $this->tokenStorage->setToken($authToken);

        $request->getSession()->remove(Security::AUTHENTICATION_ERROR);
        $request->getSession()->remove(Security::LAST_USERNAME);

        if (null !== $this->dispatcher) {
            $loginEvent = new InteractiveLoginEvent($request, $authToken);
            $this->dispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $loginEvent);
        }

        return null;
    }

    public function supports(Request $request)
    {
        return $request->getPathInfo() == '/secure-emailing' || $request->query->has('jwt');
    }

    /**
     * @inheritDoc
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
