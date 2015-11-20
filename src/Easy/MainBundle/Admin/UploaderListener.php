<?php
namespace Easy\MainBundle\Admin;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Oneup\UploaderBundle\Event\PreUploadEvent;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;

class UploaderListener
{

    private $em;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }


    /**
     * @param PostPersistEvent $event
     */

    public function onUpload(PostPersistEvent $event){
        echo "onUpload";die();
    }
    public function preUpload(PreUploadEvent $event)
    {
        //echo "preUpload";die();
        /*$response = $event->getResponse();
        $msg = "test";
        $response->setSuccess(false);
        $response->setError($msg);*/


        $galleryId = $event->getRequest()->get('galleryId');

        $file = $event->getFile();
        $media = new Media();
        //$media->setName($file->getBasename());
        $media->setName($file->getClientOriginalName());
        $media->setBinaryContent($file);
        $media->setEnabled(true);
        $media->setContext('default');
        $media->setProviderName('sonata.media.provider.image');

        $this->em = $this->doctrine[0]->getEntityManager();
        $gallery = $this->em->getRepository('ApplicationSonataMediaBundle:Gallery')->find($galleryId);


        $galleryHasMedia = new GalleryHasMedia();
        $galleryHasMedia->setMedia($media);
        $galleryHasMedia->setEnabled(true);
        $gallery->addGalleryHasMedias($galleryHasMedia);

        $this->em->persist($galleryHasMedia);
        $this->em->persist($media);
        $this->em->flush();

        die();
    }
}