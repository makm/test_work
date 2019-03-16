<?php

namespace App\Controller;

use App\ImageResize\PreviewMaker;
use App\UploadFileProcess\MoveFileProcessorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    public const PREVIEW_W = 100;
    public const PREVIEW_H = 100;
    /**
     * @var MoveFileProcessorInterface
     */
    private $moveFileProcessor;

    /**
     * @var PreviewMaker
     */
    private $previewMaker;

    /**
     * UploadController constructor.
     * @param MoveFileProcessorInterface $moveFileProcessor
     * @param PreviewMaker $previewMaker
     */
    public function __construct(MoveFileProcessorInterface $moveFileProcessor, PreviewMaker $previewMaker)
    {
        $this->moveFileProcessor = $moveFileProcessor;
        $this->previewMaker = $previewMaker;
    }

    /**
     * @param Request $request
     */
    private function fetchFileSource(Request $request)
    {
        
    }

    /**
     * @Route("/upload", methods={"POST","PUT"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Gumlet\ImageResizeException
     */
    public function uploadAction(Request $request): JsonResponse
    {
        $uploadSources = [];


        return new JsonResponse();
    }
}