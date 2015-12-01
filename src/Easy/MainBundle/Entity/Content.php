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
    private $order_column = null;

    /**
     * @var boolean
     */
    private $top_menu;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $teams;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Gallery
     */
    private $gallery;

    /**
     * @var \Easy\MainBundle\Entity\MainMenu
     */
    private $url;

    /**
     * @var \Easy\MainBundle\Entity\City
     */
    private $city;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->second_menu = 1;
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
     * Add teams
     *
     * @param \Easy\MainBundle\Entity\Team $teams
     * @return Content
     */
    public function addTeam(\Easy\MainBundle\Entity\Team $team)
    {
        $team->setContent($this);
        $this->teams->add($team);
        
    }

    /**
     * Remove teams
     *
     * @param \Easy\MainBundle\Entity\Team $teams
     */
    public function removeTeam(\Easy\MainBundle\Entity\Team $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }
    
//    public function setTeams(\Easy\MainBundle\Entity\Team $teams)
//    {
//        foreach ($teams as $team) {
//            $this->addTeam($team);
//        }
//    }

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

    /**
     * Set url
     *
     * @param \Easy\MainBundle\Entity\MainMenu $url
     * @return Content
     */
    public function setUrl(\Easy\MainBundle\Entity\MainMenu $url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return \Easy\MainBundle\Entity\MainMenu 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set city
     *
     * @param \Easy\MainBundle\Entity\City $city
     * @return Content
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
    
    public static function getTypes()
    {
        return array(
            'content' => 'Текст',
            'gallery' => 'Текст с небольшой фотогалерей', // галерея с текстом, 3 шт фотки
            'video' => 'Видеоблок', // видео, загружаемое файлом
            'slider' => 'Слайдер', //слайдер, команда, учителя
            'photo' => 'Фотографии', // фотки с попапом
            'contacts' => 'Контакты (карта)', // контакты
            'news' => 'news', // блок новости ?
//            'calendar' => 'calendar', // календарь событий в гашей жизни
//            'video_gallery' => 'video_gallery', //видео галлерея
//            'news_all' => 'news_all', //все новости в нашей жизни подробнее
//            'calendar_all' => 'calendar_all', //все события календаря в подробнее
//            'photo_links' => 'photo_links', // ссылки фотогаллерей на фотки непосредственно
            'stuff' => 'Преподаватели', // преподователи
        );
    }
    /**
     * @var integer
     */
    private $second_menu;


    /**
     * Set second_menu
     *
     * @param integer $secondMenu
     * @return Content
     */
    public function setSecondMenu($secondMenu)
    {
        $this->second_menu = $secondMenu;

        return $this;
    }

    /**
     * Get second_menu
     *
     * @return integer 
     */
    public function getSecondMenu()
    {
        return $this->second_menu;
    }
    
    
    /**
     * @var string
     */
    private $content;


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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contacts;


    /**
     * Add contacts
     *
     * @param \Easy\MainBundle\Entity\Contacts $contacts
     * @return Content
     */
    public function addContact(\Easy\MainBundle\Entity\Contacts $contacts)
    {
        $contacts->setContentReference($this);
        $this->contacts->add($contacts);

        //return $this;
    }
//    public function addTeam(\Easy\MainBundle\Entity\Team $team)
//    {
//        $team->setContent($this);
//        $this->teams->add($team);
//        
//    }

    /**
     * Remove contacts
     *
     * @param \Easy\MainBundle\Entity\Contacts $contacts
     */
    public function removeContact(\Easy\MainBundle\Entity\Contacts $contacts)
    {
        //dump($contacts,$this->contacts,$this->contacts->removeElement($contacts));die();
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }
    
//    public function setContacts(\Easy\MainBundle\Entity\Contacts $contacts)
//    {
//        foreach ($contacts as $contact) {
//            $this->addContact($contact);
//        }
//    }
    
    /**
     * @var string
     */
    private $stuff;


    /**
     * Set stuff
     *
     * @param string $stuff
     * @return Content
     */
    public function setStuff($stuff)
    {
        $this->stuff = $stuff;

        return $this;
    }

    /**
     * Get stuff
     *
     * @return string 
     */
    public function getStuff()
    {
        return $this->stuff;
    }

    public function __toString(){
        return $this->getName();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */

}
