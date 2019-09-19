<?php


namespace App\Service;


use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    const USER_IMAGE = 'images/profile';
    private $uploadPath;
    private $requestStackContext;

    public function __construct(string $uploadPath, RequestStackContext $requestStackContext)
    {
        $this->uploadPath = $uploadPath;
        $this->requestStackContext = $requestStackContext;
    }

    public function uploadUserImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadPath.'/'.self::USER_IMAGE;

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }

    public function getPublicPath(string $path): string
    {
        return $this->requestStackContext
        ->getBasePath().'/uploads/'.$path;
    }
}