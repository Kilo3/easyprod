<?php

namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\FileProvider;
use Sonata\MediaBundle\Provider\BaseProvider;
use Sonata\MediaBundle\Provider\ImageProvider;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\File\File;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\MediaBundle\CDN\CDNInterface;
use Sonata\MediaBundle\Generator\GeneratorInterface;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;
use Sonata\MediaBundle\Thumbnail\ThumbnailInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;



use Symfony\Component\HttpFoundation\File\UploadedFile;
use Application\Sonata\MediaBundle\Entity\Media;



/**
 * Class CustomProvider
 * @package Application\Sonata\MediaBundle\Provider
 */
class CustomProvider extends FileProvider
{

    public function buildCreateForm(FormMapper $formMapper)
    {
        //$currentRoute = $request->attributes->get('_route');

        //dump($formMapper->getAdmin()->getRequest()->getUri());die();
        //$formMapper->add('binaryContent', 'file', array( 'required'=>false));
        $formMapper->add('name', 'hidden', array( 'required'=>false));
    }

    /**
     * @param MediaInterface $media
     */
   /* protected function doTransform(MediaInterface $media)
    {
        $mediaManager = $this->container->get('sonata.media.manager.media');
        $mediaTemp = new Media();
        $mediaTemp->setBinaryContent($media->getBinaryContent()[0]);
        $mediaTemp->setContext('default');

        $mediaTemp->setProviderName('sonata.media.provider.image');



//        dump($this, $media,$mediaTemp);die();

        $this->fixBinaryContent($media);
        $this->fixFilename($media);

        // this is the name used to store the file
        if (!$media->getProviderReference()) {
            $media->setProviderReference($this->generateReferenceName($media));
        }

        if ($media->getBinaryContent()) {
            $media->setContentType($media->getBinaryContent()->getMimeType());
            $media->setSize($media->getBinaryContent()->getSize());
        }

        $media->setProviderStatus(MediaInterface::STATUS_OK);
    }*/
}