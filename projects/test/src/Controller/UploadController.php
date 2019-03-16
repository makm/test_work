<?php

namespace App\Controller;

use App\ImageResize\PreviewMaker;
use App\UploadFileProcess\MoveFileProcessorInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * @return array
     */
    private function fetchSourceListByRequest(Request $request): array
    {
        /** json body content (only)*/
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
            return $parametersAsArray['files'] ?? [];
        }

        $uploadSources = [];

        /**
         * direct file uploaded
         */

        if ($uploads = $request->files->get('files')) {
            foreach ($uploads as $upload) {
                if ($upload instanceof UploadedFile) {
                    $uploadSources[] = $upload->getRealPath();
                }
            }
        }

        /**
         * base64 or url loaded
         */
        if ($uploads = $request->request->get('files')) {
            foreach ($uploads as $upload) {
                $uploadSources[] = $upload;
            }
        }

        return $uploadSources;
    }

    /**
     * Upload files from any source
     *
     * @Route("/api/upload", methods={"POST"})
     * @SWG\Post(
     *     consumes={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns uploaded files paths",
     * )
     *
     * @SWG\Parameter(
     *     collectionFormat="multi",
     *     name="files",
     *     in="query",
     *     type="array",
     *     @SWG\Items(type="string"),
     *     description="The field or file's sourses"
     * )
     *
     * @SWG\Parameter(
     *     collectionFormat="multi",
     *     name="files",
     *     in="formData",
     *     type="array",
     *     @SWG\Items(type="string", format="binary"),
     *     description="The field string file binary source"
     * )
     *
     * @SWG\Parameter(
     *     name="files",
     *     in="body",
     *     @SWG\Schema(type="object", example={"files":
     *     {
     *              "http://kakrig.com/wp-content/cache/thumb/9da6cbcdb_320x200.jpg",
     *              "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
     *      }
     *     }),
     *     type="string",
     *     description="The field body"
     * )
     *
     * @SWG\Tag(name="Uploads")
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Gumlet\ImageResizeException
     */
    public function uploadAction(Request $request): JsonResponse
    {
        $uploadSources = $this->fetchSourceListByRequest($request);

        /**
         * prepare response (upload, decode, remove and create preview)
         */
        $uploadFiles = [];
        $previewFiles = [];
        foreach ($uploadSources as $uploadSource) {
            if ($this->moveFileProcessor->validate($uploadSource)) {
                $uploadFiles[] = $newFileImage = $this->moveFileProcessor->move($uploadSource);
                $previewFiles[] = $this->previewMaker->make($newFileImage, self::PREVIEW_W, self::PREVIEW_H);
            } else {
                throw new HttpException(400, "Can't detect file source");
            }
        }

        return new JsonResponse([
            'uploads' => $uploadFiles,
            'previews' => $previewFiles,
        ]);
    }
}