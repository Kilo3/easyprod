<?php

namespace Easy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Easy\MainBundle\Entity\Stuff;

class DefaultController extends Controller
{
    public function indexAction($part1=NULL, $part2 = NULL)
    {
        /*if($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '178.217.68.239'){
            header("Location:/");
            die();
        }*/

        $hp = $this->getDoctrine()->getManager();
        $currentUrl = $hp->getRepository('EasyMainBundle:MainMenu')->findOneBy(array('url'=>$part1, 'empty' => false));
        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        if(!isset($currentUrl)){
            $topMenu = "";
            return $this->render('EasyMainBundle:Page:404.html.twig', array(
                'mainMenu' => $mainMenu,
                'topMenu' => $topMenu,
                'color' => 'purple'
            ));
        }
        $foo = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent'=>$currentUrl->getId()), array('order_column'=>'ASC'));
        if($foo == NULL){
            $secondLayerMenu = NULL;
        }elseif(count($foo) > 0){
            $boo = $this->render('EasyMainBundle:Block:secondLayerMenu.html.twig', array(
                'menuList'   => $foo,
            ));
            $secondLayerMenu = $boo->getContent();
            //$secondLayerMenu = $hp->getRepository('EasyMainBundle:Content')->findBy(array('url'=> $foo->getId()));
        }
        
        $content = $hp->getRepository('EasyMainBundle:Content')->findBy(array('url'=>$currentUrl->getId()), array('order_column'=>'ASC'));
        $topMenu = array();
        foreach ($content as $key => $value){
            //topmenu
            if($value->getTopMenu() == true){
                $topMenu[] = array('section'=>$key+1, 'title'=>$value->getName());
            }
            //content final
            switch ($value->getType()) {
                case 'video':
                    $foo = $this->render('EasyMainBundle:Block:block_video.html.twig', array(
                        'content'   => $value,
                        'gallery'   => $value->getGallery(),
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'gallery':

                    $foo = explode("<p>&nbsp;</p>\r\n",$value->getContent());

                    if(count($foo) == 3){
                        $foo = $this->render('EasyMainBundle:Block:block_gallery.html.twig', array(
                            'content'   => $value,
                            'splitted' => $foo,
                            'gallery'   => $value->getGallery(),
                        ));
                    }else{
                        $foo = $this->render('EasyMainBundle:Block:block_gallery.html.twig', array(
                            'content'   => $value,
                            'gallery'   => $value->getGallery(),
                        ));
                    }

                 

                    $value->setContent($foo->getContent());
                    break;
                
                case 'slider':
                 
                    $foo = $this->render('EasyMainBundle:Block:block_slider.html.twig', array(
                        'content'   => $value,
                        //'gallery'   => $value->getGallery(),
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'photo':
                 
                    $foo = $this->render('EasyMainBundle:Block:block_photo.html.twig', array(
                        'content'   => $value,
                        //'gallery'   => $value->getGallery(),
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'calendar':
                    $em = $this->getDoctrine()->getEntityManager();
                    $qb = $em->createQueryBuilder();
                    $qb->select('e.id, e.name, YEAR(e.date) AS year, MONTH(e.date) AS month, e.date, e.text, m.id AS mediaId')
                        ->from( 'EasyMainBundle:Calendar',  'e' )
//                    ->Where(
//                        $qb->expr()->andX(
//                            $qb->expr()->between('e.dateStart', ':from', ':to')
//                        )
//                    )

                        //->join('e', 'media__media', 'm', 'e.media_id = m.id')
                        ->join('e.media','m')

                        //->groupBy('month')
                        ->orderBy('e.date', 'ASC')
                        //->setFirstResult( $offset )
                        //->setMaxResults( $limit );
                    ;
                    $month = array();
                    $calendarItems = $qb->getQuery()->getResult();
                    foreach ($calendarItems as $itemIndex => $item) {
                        $media = $hp->getRepository('Application\Sonata\MediaBundle\Entity\Media')->find($item['mediaId']);
                        $calendarItems[$itemIndex]['media'] = $media;
                        switch($item['month']){
                            case 1:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Январь';
                                break;
                            case 2:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Февраль';
                                break;
                            case 3:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Март';
                                break;
                            case 4:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Апрель';
                                break;
                            case 5:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Май';
                                break;
                            case 6:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Июнь';
                                break;
                            case 7:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Июль';
                                break;
                            case 8:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Август';
                                break;
                            case 9:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Сентябрь';
                                break;
                            case 10:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Октябрь';
                                break;
                            case 11:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Ноябрь';
                                break;
                            case 12:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Декабрь';
                                break;
                        }
                    }
                    foreach ($month as $year) {
                        ksort($year);
                    }
                    ksort($month);
                    $foo = $this->render('EasyMainBundle:Block:block_calendar.html.twig', array(
                        'month'   => $month,
                        'content'   => $value,
                    ));
                    
                    
                    $value->setContent($foo->getContent());
                    break;
                
                case 'video_gallery':
                    $foo = $this->render('EasyMainBundle:Block:block_video_gallery.html.twig', array(
                        'content'   => $value,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'news':
                    
                    $repository = $this->getDoctrine()->getRepository('EasyMainBundle:News');
                    $date_from = date('Y-m-d');
                    $contacts = $repository->createQueryBuilder('s')
                        ->where('s.date >= :date_from', 's.type = :type')
                        ->setParameter('date_from', $date_from)
                        ->setParameter('type', 'published')
                        ->orderBy("s.date", 'DESC')
                        ->setMaxResults(3)
                        ->getQuery();
                    $news = $contacts->getResult();
                    
                    if(count($news) < 3 ){
                        $news = $hp->getRepository('EasyMainBundle:News')->findBy(array('type' => 'published'), array('date'=>'DESC'), 3);
                    }
                    $foo = $this->render('EasyMainBundle:Block:block_news.html.twig', array(
                        'content'   => $value,
                        'news'   => $news
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'content':
                 
                    $foo = $this->render('EasyMainBundle:Block:block_content.html.twig', array(
                        'content'   => $value
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'easy_times':
                    $times = $hp->getRepository('Easy\MainBundle\Entity\Times')->findAll();
                    $foo = $this->render('EasyMainBundle:Block:block_easy_times.html.twig', array(
                        'content'   => $value,
                        'times'   => $times,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'contacts':
                    $foo = $this->render('EasyMainBundle:Block:block_contacts.html.twig', array(
                        'content'   => $value
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'stuff':
                    
                    $repository = $this->getDoctrine()->getRepository('EasyMainBundle:Stuff');
                    $query = $repository->createQueryBuilder('s')
                        ->where('s.type = :type')
                        ->setParameter('type', $value->getStuff())
                        ->orderBy("s.name", 'ASC')
                        ->getQuery();
                    $stuff = $query->getResult();
                    
                    shuffle($stuff);

                    $stuff = array_slice($stuff, 0, 3, true);
                    
                    $foo = $this->render('EasyMainBundle:Block:block_stuff.html.twig', array(
                        'content'   => $value,
                        'stuff'   => $stuff
                    ));
                    $value->setContent($foo->getContent());
                    break;

                default:
                    break;
            }
        }
        $teacherMenu = Stuff::getTypes();


        return $this->render('EasyMainBundle::layout.html.twig', array(
            'mainMenu' => $mainMenu,
            'content' => $content,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'teacherMenu' => $teacherMenu,
            'color' => $currentUrl->getColor(),
            'root' => $currentUrl->getId()
        ));
    }
    
    public function indexPart2Action($part1=NULL, $part2 = NULL)
    {
        /*if($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '178.217.68.239'){
            header("Location:/");
            die();
        }*/
        $hp = $this->getDoctrine()->getManager();
        $boo = $hp->getRepository('EasyMainBundle:MainMenu')->findOneBy(array('url'=>$part1));
        $foo = $hp->getRepository('EasyMainBundle:MainMenu')->findOneBy(array('url'=>$part2, 'parent' => $boo->getId(),'empty' => false));
        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        if(isset($foo)){
            $content = $hp->getRepository('EasyMainBundle:Content')->findBy(array('url'=>$foo->getId()), array('order_column'=>'ASC'));
        }else{
            $topMenu = "";
            return $this->render('EasyMainBundle:Page:404.html.twig', array(
                'mainMenu' => $mainMenu,
                'topMenu' => $topMenu,
                'color' => 'purple'
            ));
        }

        $currentUrl = $hp->getRepository('EasyMainBundle:MainMenu')->findOneBy(array('url'=>$part1));
        
//        if($foo != NULL){
//            $secondLayerMenu = $hp->getRepository('EasyMainBundle:Content')->findBy(array('url'=> $foo->getId()));
//        }else{
//            $secondLayerMenu = NULL;
//        }
        //echo "<pre>";var_dump($foo);die();
        
        
        $topMenu = array();
        foreach ($content as $key => $value){
            //topmenu
            if($value->getTopMenu() == true){
                $topMenu[] = array('section'=>$key+1, 'title'=>$value->getName());
            }
            //content final
            switch ($value->getType()) {
                case 'video':
                    $foo = $this->render('EasyMainBundle:Block:block_video.html.twig', array(
                        'content'   => $value,
                        'gallery'   => $value->getGallery(),
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'gallery':
                 
                    $foo = $this->render('EasyMainBundle:Block:block_gallery.html.twig', array(
                        'content'   => $value,
                        'gallery'   => $value->getGallery(),
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'content':
                    
                    if($value->getGallery()){
                        $goo = $value->getGallery()->getId();
                    }else{
                        $goo = NULL;
                    }
//                    dump($goo);die();
                    
                    $foo = $this->render('EasyMainBundle:Block:block_content.html.twig', array(
                        'content'   => $value,
                        'galleryId' => $goo
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'slider':

                    //dump($value->getTeams());die();
                    $foo = $this->render('EasyMainBundle:Block:block_slider.html.twig', array(
                        'content'   => $value,
                        //'gallery'   => $value->getGallery(),
                    ));
                    $value->setContent($foo->getContent());
                    break;
                case 'photo':
                 
                    $foo = $this->render('EasyMainBundle:Block:block_photo.html.twig', array(
                        'content'   => $value,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                 case 'video_gallery':
                    $foo = $this->render('EasyMainBundle:Block:block_video_gallery.html.twig', array(
                        'content'   => $value,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'news_all':
                    $news = $hp->getRepository('EasyMainBundle:News')->findBy(array(), array('order_column'=>'ASC'));
                    $foo = $this->render('EasyMainBundle:Page:block_news_all.html.twig', array(
                        'content'   => $value,
                        'news'   => $news,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'calendar_all':
                    $calendar = $hp->getRepository('EasyMainBundle:Calendar')->findBy(array(), array('date'=>'DESC'));
                    $foo = $this->render('EasyMainBundle:Block:block_calendar_all.html.twig', array(
                        'content'   => $value,
                        'calendar'   => $calendar,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'photo_links':
                    $galleries = $hp->getRepository('EasyMainBundle:PhotoGallery')->findAll();
                    $foo = $this->render('EasyMainBundle:Block:block_photo_links.html.twig', array(
                        'content'   => $value,
                        'galleries'   => $galleries,
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'contacts':
                    $foo = $this->render('EasyMainBundle:Block:block_contacts.html.twig', array(
                        'content'   => $value
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'news':
                    $news = $hp->getRepository('EasyMainBundle:News')->findBy(array(), array('order_column'=>'ASC'), 3);
                    $foo = $this->render('EasyMainBundle:Block:block_news.html.twig', array(
                        'content'   => $value,
                        'news'   => $news
                    ));
                    $value->setContent($foo->getContent());
                    break;
                
                case 'calendar':
                    $em = $this->getDoctrine()->getEntityManager();
                    $qb = $em->createQueryBuilder();
                    $qb->select('e.id, e.name, YEAR(e.date) AS year, MONTH(e.date) AS month, e.date, e.text, m.id AS mediaId')
                    ->from( 'EasyMainBundle:Calendar',  'e' )
//                    ->Where( 
//                        $qb->expr()->andX(
//                            $qb->expr()->between('e.dateStart', ':from', ':to')
//                        )
//                    )
                            
                    //->join('e', 'media__media', 'm', 'e.media_id = m.id')
                    ->join('e.media','m')
                            
                    //->groupBy('month')
                    ->orderBy('e.date', 'ASC')
                    //->setFirstResult( $offset )
                    //->setMaxResults( $limit );
                    ;
                    $month = array();
                    $calendarItems = $qb->getQuery()->getResult();
                    foreach ($calendarItems as $itemIndex => $item) {
                        $media = $hp->getRepository('Application\Sonata\MediaBundle\Entity\Media')->find($item['mediaId']);
                        $calendarItems[$itemIndex]['media'] = $media;
                        switch($item['month']){
                            case 1:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Январь';
                                break;
                            case 2:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Февраль';
                                break;
                            case 3:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Март';
                                break;
                            case 4:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Апрель';
                                break;
                            case 5:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Май';
                                break;
                            case 6:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Июнь';
                                break;
                            case 7:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Июль';
                                break;
                            case 8:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Август';
                                break;
                            case 9:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Сентябрь';
                                break;
                            case 10:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Октябрь';
                                break;
                            case 11:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Ноябрь';
                                break;
                            case 12:
                                $month[$item['year']][$item['month']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['year']][$item['month']]['monthRus'] = 'Декабрь';
                                break;
                        }
                    }
                    foreach ($month as $year) {
                        ksort($year);
                    }
                    ksort($month);
                    $foo = $this->render('EasyMainBundle:Block:block_calendar.html.twig', array(
                        'month'   => $month,
                        'content'   => $value,
                    ));
                    
                    
                    $value->setContent($foo->getContent());
                    break;

                default:
                    break;
            }
        }
        
        $teacherMenu = Stuff::getTypes();


        return $this->render('EasyMainBundle::layout.html.twig', array(
            'mainMenu' => $mainMenu,
            'content' => $content,
            'topMenu' => $topMenu,
            //'secondLayerMenu' => $secondLayerMenu,
            'teacherMenu' => $teacherMenu,
            'color' => $currentUrl->getColor(),
            'root' => $currentUrl->getId()
        ));
    }
    
    public function mainAction()
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        $mainPageSeo = $hp->getRepository('EasyMainBundle:MainMenu')->findOneBy(array('id' => 8)); // id = 8 корень меню

        return $this->render('EasyMainBundle:Default:index.html.twig', array(
            'mainMenu' => $mainMenu,
            'seo' => $mainPageSeo
        ));
        /*return $this->render('EasyMainBundle:Default:maintaince.html.twig', array(
            'mainMenu' => $mainMenu
        ));*/
    }
    
    public function newsAction()
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        
        $news = $hp->getRepository('EasyMainBundle:News')->findBy(array("type" => "published"), array('order_column'=>'ASC'));
        $archive = $hp->getRepository('EasyMainBundle:News')->findBy(array("type" => "archive"), array('order_column'=>'ASC'));
        
        $topMenu = "";
        $secondLayerMenu = "";
        return $this->render('EasyMainBundle:Page:news.html.twig', array(
            'mainMenu' => $mainMenu,
            'news' => $news,
            'archive' => $archive,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'color' => 'salad'
        ));
    }
    
    public function easyTimesAction()
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню

        $times = $hp->getRepository('Easy\MainBundle\Entity\Times')->findAll();
        
        
        $topMenu = "";
        $secondLayerMenu = "";
        return $this->render('EasyMainBundle:Page:easy_times.html.twig', array(
            'mainMenu' => $mainMenu,
            'content' => $times,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'color' => 'salad'
        ));
    }
    
    public function newsShowAction($id)
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        
        $content = $hp->getRepository('EasyMainBundle:News')->findOneBy(array('id' => $id), array('order_column'=>'ASC'));
        
        $topMenu = "";
        $secondLayerMenu = "";
        
        return $this->render('EasyMainBundle:Page:news_show.html.twig', array(
            'mainMenu' => $mainMenu,
            'content' => $content,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'color' => 'salad'
        ));
    }

    public function galleryAction($id)
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню

        $content = $hp->getRepository('Easy\MainBundle\Entity\PhotoGallery')->findOneBy(array('id' => $id));

        $topMenu = "";
        $secondLayerMenu = "";
        return $this->render('EasyMainBundle:Page:gallery_show.html.twig', array(
            'mainMenu' => $mainMenu,
            'content' => $content,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'color' => 'salad'
        ));
    }

    public function linkedgalleryAction($id)
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню

        $content = $hp->getRepository('Application\Sonata\MediaBundle\Entity\Gallery')->findOneBy(array('id' => $id));

        $topMenu = "";
        $secondLayerMenu = "";
        return $this->render('EasyMainBundle:Page:linkedgallery_show.html.twig', array(
            'mainMenu' => $mainMenu,
            'content' => $content,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'color' => 'salad'
        ));
    }
    
    public function calendarAction($id)
    {
        if($id == 'all'){
            $hp = $this->getDoctrine()->getManager();
            $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8));
            $content = $hp->getRepository('EasyMainBundle:Calendar')->findAll();

            $topMenu = "";
            $secondLayerMenu = "";
            return $this->render('EasyMainBundle:Block:block_calendar_all.html.twig', array(
                'mainMenu' => $mainMenu,
                'calendar' => $content,
                'topMenu' => $topMenu,
                'secondLayerMenu' => $secondLayerMenu,
                'color' => 'salad'
            ));
        }else{
            $hp = $this->getDoctrine()->getManager();

            $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню

            $content = $hp->getRepository('EasyMainBundle:Calendar')->findOneBy(array('id' => $id));

            $topMenu = "";
            $secondLayerMenu = "";
            return $this->render('EasyMainBundle:Page:calendar_show.html.twig', array(
                'mainMenu' => $mainMenu,
                'content' => $content,
                'topMenu' => $topMenu,
                'secondLayerMenu' => $secondLayerMenu,
                'color' => 'salad'
            ));
        }
    }
    
    public function contactsAction($id)
    {
        $hp = $this->getDoctrine()->getManager();
        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        if($id == 'all'){
            
            $repository = $this->getDoctrine()->getRepository('EasyMainBundle:Contacts');
            $contacts = $repository->createQueryBuilder('cc')
                ->select()
                ->distinct()
                ->getQuery();
            $result = $contacts->getResult();
            
            $temp = new \Easy\MainBundle\Entity\Content();
            $temp->setContacts($result);
            $temp->setName('Все контакты');
            
            //dump($temp);die();
            
            $foo = $this->render('EasyMainBundle:Block:block_contacts.html.twig', array(
                'content'   => $temp
            ));
            $content = $foo->getContent();
            $topMenu = "";
            $secondLayerMenu = "";
            return $this->render('EasyMainBundle:Page:contacts_all.html.twig', array(
                'mainMenu' => $mainMenu,
                'content' => $content,
                'topMenu' => $topMenu,
                'secondLayerMenu' => $secondLayerMenu,
                'color' => 'purple'
            ));
        }elseif($id == 'all_show'){
            $repository = $this->getDoctrine()->getRepository('EasyMainBundle:Contacts');
            $contacts = $repository->createQueryBuilder('cc')
                ->select()
                ->distinct()
                ->getQuery();
            $result = $contacts->getResult();
            
            $temp = new \Easy\MainBundle\Entity\Content();
            $temp->setContacts($result);
            

            $topMenu = "";
            $secondLayerMenu = "";
            return $this->render('EasyMainBundle:Page:contacts.html.twig', array(
                'mainMenu' => $mainMenu,
                'content' => $temp,
                'topMenu' => $topMenu,
                'secondLayerMenu' => $secondLayerMenu,
                'color' => 'purple'
            ));
        }else{
            
        
            

            $content = $hp->getRepository('EasyMainBundle:Content')->findOneBy(array('id' => $id));
            $color = $content->getUrl()->getColor();

            $topMenu = "";
            $secondLayerMenu = "";
            return $this->render('EasyMainBundle:Page:contacts.html.twig', array(
                'mainMenu' => $mainMenu,
                'content' => $content,
                'topMenu' => $topMenu,
                'secondLayerMenu' => $secondLayerMenu,
                'color' => $color
            ));
        }
        //
        
    }
    
    
    public function stuffAction($type)
    {
        $type = str_replace('/','',$type); // некорректно, нужно через routing работать
        $hp = $this->getDoctrine()->getManager();
        $mainMenu = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1)); // id = 8 корень меню
        $title = Stuff::getTypes();
        if($type == 'all'){
            $stuff = $hp->getRepository('EasyMainBundle:Stuff')->findAll();
            $all = 1;
        }else{
            $stuff = $hp->getRepository('EasyMainBundle:Stuff')->findBy(array('type' => $type),array('name'=>'ASC'));
            $all = 0;
        }

        if(count($stuff) > 0){
            return $this->render('EasyMainBundle:Default:stuff.html.twig', array(
                'mainMenu' => $mainMenu,
                'content' => $stuff,
                'color' => 'purple',
                'title' => $title,
                'all' => $all,
            ));
        }else{
            $topMenu = "";
            return $this->render('EasyMainBundle:Page:404.html.twig', array(
                'mainMenu' => $mainMenu,
                'topMenu' => $topMenu,
                'color' => 'purple'
            ));
        }
        
        
    }
    
    
//    public function kidAction()
//    {
//        return $this->render('EasyMainBundle:Default:kid.html.twig');
//    }
//    
//    public function foreignAction()
//    {
//        return $this->render('EasyMainBundle:Default:foreign.html.twig');
//    }
//    public function summerAction()
//    {
//        return $this->render('EasyMainBundle:Default:summer.html.twig');
//    }
//    public function tsdoAction()
//    {
//        return $this->render('EasyMainBundle:Default:tsdo.html.twig');
//    }
//    
//    
//    
//    public function mainAction()
//    {
//        return $this->render('EasyMainBundle:Default:main.html.twig');
//    }
    public function testAction()
    {
        return $this->render('EasyMainBundle:Default:test.html.twig');
    }
    
    public  function loginAction(){
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        //dump($request->attributes,SecurityContext::ACCESS_DENIED_ERROR);die();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            
        }

        return $this->render('EasyMainBundle:Default:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
}
