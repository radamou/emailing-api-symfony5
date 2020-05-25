<?php

namespace Emailing\Application;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\WebUploader\WebUploaderInterface;
use Symfony\Component\Routing\Annotation\Route;

class UploadFileController extends AbstractController
{
    private const IMAGE_MIME_TYPE = ["image/jpeg","image/png","image/vnd.microsoft.icon"];
    private const MAX_IMAGE_SIZE = 40000000;

    /**
     * @Route("/upload-image", name="email_event_upload_image", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var UploadedFile $file */
        $file = $request->files->get('image');

        if($file->getClientSize() > self::MAX_IMAGE_SIZE ) {
            return $this->getApiSuccessResponse(
                [
                    'success' => false,
                    'errorType' => 'MaxSize'
                ]
            );
        }

        if(!\in_array($file->getClientMimeType(), self::IMAGE_MIME_TYPE, true)) {
            return $this->getApiSuccessResponse(
                [
                    'success' => false,
                    'errorType' => 'badFIleFormat'
                ]
            );
        }

        $response = $this->getUploader()->upload($file, '/email-events', $file->getClientOriginalName());

        return $this->getApiSuccessResponse(
            [
                'success' => true,
                'url' => $response->getBaseurl().$response->getPath()
            ]
        );
    }

    public function getUploader(): WebUploaderInterface
    {
        return $this->container->get('sympl.web_uploader');
    }
}