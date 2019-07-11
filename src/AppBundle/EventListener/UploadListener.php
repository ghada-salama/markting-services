<?php

namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadListener
{


    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function onUpload(PostPersistEvent $event)
    {
     //   $request->headers->set('Accept:', 'application/json');

        $response = $event->getResponse();
     //   $response->headers->set('Content-type', 'application/json');
        $file = $event->getFile();
        $media = new Image();
        $media->setExtension($file->getMimeType());
        $media->setSize($file->getSize());
        $media->setName($file->getFilename());
        $this->om->persist($media);
        $this->om->flush();
        $response['success'] = true;
        $response['name'] = $media->getName();
        $response['id'] = $media->getId();
        $files = array(
            'name' => $file->getFileName(),
            'size' => $file->getSize(),
            'id' => $media->getId()
        );

    }

}