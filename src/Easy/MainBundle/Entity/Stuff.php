<?php

namespace Easy\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stuff
 */
class Stuff
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
    private $text;

    /**
     * @var string
     */
    private $type;

   
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
     * @return Stuff
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
     * Set text
     *
     * @param string $text
     * @return Stuff
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Stuff
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    public static function getTypes()
    {
        return array(
            'adult_teacher' => 'Взрослые учителя',
            'kid_teacher' => 'Детские учителя',
            'kid_kendergarden' => 'Детский сад',
            'tsrr' => 'Центр раннего развития',
            'tsdo' => 'Центр дополнительного образования',
            'coordinators' => 'Координаторы',
        );
    }
    
    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $media;


    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return Stuff
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }
}
