<?php

namespace Easy\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MainMenu
 */
class MainMenu
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $lft;

    /**
     * @var integer
     */
    private $rgt;

    /**
     * @var integer
     */
    private $root;

    /**
     * @var integer
     */
    private $lvl;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $order_column;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $seo_title;

    /**
     * @var string
     */
    private $seo_description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $content;

    /**
     * @var \Easy\MainBundle\Entity\MainMenu
     */
    private $parent;

    /**
     * @var \Easy\MainBundle\Entity\City
     */
    private $city;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return MainMenu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return MainMenu
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return MainMenu
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return MainMenu
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return MainMenu
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return MainMenu
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set order_column
     *
     * @param integer $orderColumn
     * @return MainMenu
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
     * Set color
     *
     * @param string $color
     * @return MainMenu
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set seo_title
     *
     * @param string $seoTitle
     * @return MainMenu
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seo_title = $seoTitle;

        return $this;
    }

    /**
     * Get seo_title
     *
     * @return string 
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    /**
     * Set seo_description
     *
     * @param string $seoDescription
     * @return MainMenu
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seo_description = $seoDescription;

        return $this;
    }

    /**
     * Get seo_description
     *
     * @return string 
     */
    public function getSeoDescription()
    {
        return $this->seo_description;
    }

    /**
     * Add children
     *
     * @param \Easy\MainBundle\Entity\MainMenu $children
     * @return MainMenu
     */
    public function addChild(\Easy\MainBundle\Entity\MainMenu $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Easy\MainBundle\Entity\MainMenu $children
     */
    public function removeChild(\Easy\MainBundle\Entity\MainMenu $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add content
     *
     * @param \Easy\MainBundle\Entity\Content $content
     * @return MainMenu
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

    /**
     * Set parent
     *
     * @param \Easy\MainBundle\Entity\MainMenu $parent
     * @return MainMenu
     */
    public function setParent(\Easy\MainBundle\Entity\MainMenu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Easy\MainBundle\Entity\MainMenu 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set city
     *
     * @param \Easy\MainBundle\Entity\City $city
     * @return MainMenu
     */
    public function setCity(\Easy\MainBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Easy\MainBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    public function getLeveledUrl()
    {
        $prefix = "";
        for($i = 2; $i <= $this->lvl; $i++){
            $prefix .= " --- ";
        }
        return (string) $prefix.$this->getUrl();
    }

    public function __toString()
    {
        $prefix = "";
        for($i = 2; $i <= $this->lvl; $i++){
            $prefix .= " --- ";
        }
        return (string) $prefix.$this->getTitle();
    }
    public function getLeveledTitle()
    {
        return (string)$this;
    }
    public static function getColors(){
        return array(
            'purple'=>'purple',
            'yellow'=>'yellow',
            'lightBlue'=>'lightBlue',
            'blue'=>'blue',
            'green'=>'green',
            'salad'=>'salad',
        );
    }
    /**
     * @var boolean
     */
    private $enabled;


    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return MainMenu
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    /**
     * @var boolean
     */
    private $empty;


    /**
     * Set empty
     *
     * @param boolean $empty
     * @return MainMenu
     */
    public function setEmpty($empty)
    {
        $this->empty = $empty;

        return $this;
    }

    /**
     * Get empty
     *
     * @return boolean 
     */
    public function getEmpty()
    {
        return $this->empty;
    }
    /**
     * @var string
     */
    private $seo_keywords;


    /**
     * Set seo_keywords
     *
     * @param string $seoKeywords
     * @return MainMenu
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seo_keywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seo_keywords
     *
     * @return string 
     */
    public function getSeoKeywords()
    {
        return $this->seo_keywords;
    }
    /**
     * @var boolean
     */
    private $record;


    /**
     * Set record
     *
     * @param boolean $record
     * @return MainMenu
     */
    public function setRecord($record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get record
     *
     * @return boolean 
     */
    public function getRecord()
    {
        return $this->record;
    }
}
