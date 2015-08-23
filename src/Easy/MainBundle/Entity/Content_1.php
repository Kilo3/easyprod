<?php

namespace Easy\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 */
class Content
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $url_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $order_column;

    /**
     * @var boolean
     */
    private $top_menu;


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
     * Set url_id
     *
     * @param integer $urlId
     * @return Content
     */
    public function setUrlId($urlId)
    {
        $this->url_id = $urlId;

        return $this;
    }

    /**
     * Get url_id
     *
     * @return integer 
     */
    public function getUrlId()
    {
        return $this->url_id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Content
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
     * @return Content
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
     * Set content
     *
     * @param string $content
     * @return Content
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
     * Set order_column
     *
     * @param integer $orderColumn
     * @return Content
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
     * Set top_menu
     *
     * @param boolean $topMenu
     * @return Content
     */
    public function setTopMenu($topMenu)
    {
        $this->top_menu = $topMenu;

        return $this;
    }

    /**
     * Get top_menu
     *
     * @return boolean 
     */
    public function getTopMenu()
    {
        return $this->top_menu;
    }
    
     /**
     * @var \Application\Sonata\MediaBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Set gallery
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return Content
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
    
    public static function getTypes()
    {
        return array(
            'gallery' => 'gallery', 
            'video' => 'video',
            'content' => 'content',
            'slider' => 'slider',
            'photo' => 'photo',
            );
    }
    
    
    
   
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $team;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inspections = new ArrayCollection();
    }

    /**
     * Add team
     *
     * @param \Easy\MainBundle\Entity\Team $team
     * @return Content
     */
    public function addTeam(\Easy\MainBundle\Entity\Team $team)
    {
        $this->team[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \Easy\MainBundle\Entity\Team $team
     */
    public function removeTeam(\Easy\MainBundle\Entity\Team $team)
    {
        $this->team->removeElement($team);
    }

    /**
     * Get team
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeam()
    {
        return $this->team;
    }
    
    
    /**
     * @ORM\OneToMany(targetEntity="Inspection", cascade={"persist", "remove"}, mappedBy="car")
     * @Assert\Valid
     */
    protected $inspections;
    
    /**
     * @param Inspection[] $inspections
     */
    public function setInspections($inspections)
    {
        $this->inspections->clear();
        foreach ($inspections as $inspection) {
            $this->addInspection($inspection);
        }
    }
    /**
     * @return Inspection[]
     */
    public function getInspections()
    {
        return $this->inspections;
    }
    /**
     * @param Inspection $inspection
     * @return void
     */
    public function addInspection(Inspection $inspection)
    {
        $inspection->setCar($this);
        $this->inspections->add($inspection);
    }
    /**
     * @param Inspection $inspection
     * @return void
     */
    public function removeInspection(Inspection $inspection)
    {
        $this->inspections->removeElement($inspection);
    }
}
