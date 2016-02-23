<?php

namespace Easy\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contacts
 */
class Contacts
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $coordinates;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contacts
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Contacts
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set coordinates
     *
     * @param string $coordinates
     * @return Contacts
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string 
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Contacts
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set gallery
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return Contacts
     */
    public function setGallery(\Application\Sonata\MediaBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }
    

    /**
     * @ORM\PrePersist
     */
    public function setCoordinatesValue()
    {
        $foo = self::getAddress();
        $url = "https://geocode-maps.yandex.ru/1.x/?geocode=".$foo;
        $url = str_replace(' ', '+', $url);
        $foo = simplexml_load_file($url);
        $newCoordinates = $foo->GeoObjectCollection->featureMember->GeoObject->Point->pos->__toString();
        $newCoordinates = explode(" ", $newCoordinates);
        $foo = $newCoordinates[1].", ".$newCoordinates[0];
        
        $this->coordinates = $foo;
        return $this;
    }
    /**
     * @var \Easy\MainBundle\Entity\Content
     */
    private $content_reference;


    /**
     * Set content_reference
     *
     * @param \Easy\MainBundle\Entity\Content $contentReference
     * @return Contacts
     */
    public function setContentReference(\Easy\MainBundle\Entity\Content $contentReference = null)
    {
        $this->content_reference = $contentReference;

        return $this;
    }

    /**
     * Get content_reference
     *
     * @return \Easy\MainBundle\Entity\Content 
     */
    public function getContentReference()
    {
        return $this->content_reference;
    }
    
//    public function __toString()
//    {
//        return (string) $this->getName();
//    }
    /**
     * @var integer
     */
    private $position;


    /**
     * Set position
     *
     * @param integer $position
     * @return Contacts
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
