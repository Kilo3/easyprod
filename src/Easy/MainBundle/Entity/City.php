<?php

namespace Easy\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 */
class City
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
    private $type;

    /**
     * @var integer
     */
    private $order_column;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $content;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->content = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return City
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
     * Set type
     *
     * @param string $type
     * @return City
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

    /**
     * Set order_column
     *
     * @param integer $orderColumn
     * @return City
     */
    public function setOrderColumn($orderColumn)
    {
        $this->order_column = $orderColumn;

        return $this;
    }

    /**
     * Get order_column
     *
     * @return integer 
     */
    public function getOrderColumn()
    {
        return $this->order_column;
    }

    /**
     * Add content
     *
     * @param \Easy\MainBundle\Entity\Content $content
     * @return City
     */
    public function addContent(\Easy\MainBundle\Entity\Content $content)
    {
        $this->content[] = $content;

        return $this;
    }

    /**
     * Remove content
     *
     * @param \Easy\MainBundle\Entity\Content $content
     */
    public function removeContent(\Easy\MainBundle\Entity\Content $content)
    {
        $this->content->removeElement($content);
    }

    /**
     * Get content
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    public function __toString()
    {
        return (string) $this->getName();
    }
}
