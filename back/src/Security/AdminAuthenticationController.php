<?php

namespace Emailing\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Emailing\Application\AbstractController;
use Emailing\Domain\Security\CustomerCompanyAccessControl;

class AdminAuthenticationController extends AbstractController
{
    /**
     * @Route("/secure-emailing", name="emailing_secure_url", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);
        $href = $request->get('href');

        return $this->redirect($href, Response::HTTP_MOVED_PERMANENTLY);
    }

    public function getGuardAuthenticationHandler(): GuardAuthenticatorHandler
    {
        return $this->container->get('security.authentication.guard_handler');
    }

    public function getAuthenticator()
    {
        return $this->container->get('sympl.security.guard_authenticator.api_key_authenticator');
    }
}