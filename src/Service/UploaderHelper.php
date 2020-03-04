<?php


namespace App\Service;


use Gedmo\Sluggable\Util\Urlizer;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    const USER_IMAGE = 'images/profile';
    const PROPERTY_IMAGE = 'images/property';
    private $uploadPath;
    private $requestStackContext;
    private $imagine;
    private const MAX_WIDTH = 800;
    private const MAX_HEIGHT = 600;

    public function __construct(string $uploadPath, RequestStackContext $requestStackContext)
    {
        $this->uploadPath = $uploadPath;
        $this->requestStackContext = $requestStackContext;
        $this->imagine = new Imagine();
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

    public function uploadPropertyImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadPath.'/'.self::PROPERTY_IMAGE;

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

    public function resize(string $filename): void
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;
        if ($width / $height > $ratio) { $width = $height * $ratio;
        }else{
            $height = $width / $ratio;
        }
        $photo = $this->imagine->open($filename);
        $photo->resize(new Box($width, $height))->save($filename);
    }
}