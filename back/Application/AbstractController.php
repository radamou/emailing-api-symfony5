<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;

class AbstractController extends AbstractFOSRestController
{
    const CURRENT_API_VERSION = 24;

    public function getClientApiVersion(): int
    {
        /** @var HeaderBag $headers */
        $headers = $this->get('request_stack')->getCurrentRequest()->headers;

        return (int) $headers->get('X-Version') ?: self::CURRENT_API_VERSION;
    }

    public function getApiSuccessResponse(array $response = [], $groups = null): Response
    {
        $context = (new Context())->setVersion($this->getClientApiVersion());
        $xTotalCount = \count($response);

        if ($groups) {
            $context->setGroups($groups);
        }

        $response = $this->handleView(
            $this->view($response)->setContext($context)
        );

        $response->headers->add(['X-Total-Count' => $xTotalCount]);

        return $response;
    }
}
