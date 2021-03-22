<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FileUploader{

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function uploadFile(UploadedFile $file)
    {
        $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

        $file->move(
             $this->container->getParameter('uploads_dir'),
             $filename
        );

        return $filename;
    }

}