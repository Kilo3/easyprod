<?php

namespace Easy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Easy\MainBundle\Entity\Stuff;

class DefaultController extends Controller
{
    public function mainMenu(){
        $hp = $this->getDoctrine()->getManager();
        return $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent' => 8, 'enabled' => 1), array('lft' => 'ASC')); // id = 8 корень меню
    }
    public function indexAction($part1=NULL, $part2 = NULL)
    {
        /*if($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '178.217.68.239'){
            header("Location:/");
            die();
        }*/

        $hp = $this->getDoctrine()->getManager();
        $currentUrl = $hp->getRepository('EasyMainBundle:MainMenu')->findOneBy(array('url'=>$part1, 'empty' => false));
        $mainMenu = $this->mainMenu();
        if(!isset($currentUrl)){
            $topMenu = "";
            return $this->render('EasyMainBundle:Page:404.html.twig', array(
                'mainMenu' => $mainMenu,
                'topMenu' => $topMenu,
                'color' => 'purple'
            ));
        }
        $foo = $hp->getRepository('EasyMainBundle:MainMenu')->findBy(array('parent'=>$currentUrl->getId()), array('lft'=>'ASC'));
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

                    if($value->getHorizontal() == true){
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
                    $qb->select('e.id, e.name, DAY(e.datestart) as daystart, YEAR(e.datestart) AS yearstart, MONTH(e.datestart) AS monthstart, YEAR(e.dateend) AS yearend, MONTH(e.dateend) AS monthend, e.datestart, e.dateend, e.text, m.id AS mediaId')
                        ->from( 'EasyMainBundle:Calendar',  'e' )
                        ->where('e.archive = false')
//                    ->Where(
//                        $qb->expr()->andX(
//                            $qb->expr()->between('e.dateStart', ':from', ':to')
//                        )
//                    )

                        //->join('e', 'media__media', 'm', 'e.media_id = m.id')
                        ->join('e.media','m')

                        //->groupBy('month')

                        ->orderBy('daystart', 'ASC')
                        ->orderBy('yearstart', 'DESC')
                        //->setFirstResult( $offset )
                        //->setMaxResults( $limit );
                    ;
                    $month = array();
                    $calendarItems = $qb->getQuery()->getResult();
                    foreach ($calendarItems as $itemIndex => $item) {
                        $media = $hp->getRepository('Application\Sonata\MediaBundle\Entity\Media')->find($item['mediaId']);
                        $calendarItems[$itemIndex]['media'] = $media;
                        switch($item['monthstart']){
                            case 1:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Январь';
                                break;
                            case 2:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Февраль';
                                break;
                            case 3:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Март';
                                break;
                            case 4:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Апрель';
                                break;
                            case 5:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Май';
                                break;
                            case 6:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Июнь';
                                break;
                            case 7:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Июль';
                                break;
                            case 8:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Август';
                                break;
                            case 9:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Сентябрь';
                                break;
                            case 10:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Октябрь';
                                break;
                            case 11:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Ноябрь';
                                break;
                            case 12:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Декабрь';
                                break;
                        }
                        //date end
                        if($item['monthend'] != $item['monthstart']) {
                            switch ($item['monthend']) {
                                case 1:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Январь';
                                    break;
                                case 2:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Февраль';
                                    break;
                                case 3:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Март';
                                    break;
                                case 4:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Апрель';
                                    break;
                                case 5:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Май';
                                    break;
                                case 6:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Июнь';
                                    break;
                                case 7:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Июль';
                                    break;
                                case 8:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Август';
                                    break;
                                case 9:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Сентябрь';
                                    break;
                                case 10:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Октябрь';
                                    break;
                                case 11:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Ноябрь';
                                    break;
                                case 12:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Декабрь';
                                    break;
                            }
                        }
                    }
                    foreach ($month as $yearKey => $year) {
                        $temp = $year;
                        ksort($temp);
                        $month[$yearKey] = $temp;
                    }

                    $foo = $this->render('EasyMainBundle:Block:block_calendar.html.twig', array(
                        'month'   => $month,
                        'content'   => $value,
                        'currentYear' => date("Y"),
                        'currentMonth' => date("m"),
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
                    $news = $this->getDoctrine()->getRepository('EasyMainBundle:News')->findBy(array('main'=>true));
                    /*
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
                    }*/
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
        $mainMenu = $this->mainMenu();
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
                    $qb->select('e.id, e.name, DAY(e.datestart) as daystart, YEAR(e.datestart) AS yearstart, MONTH(e.datestart) AS monthstart, YEAR(e.dateend) AS yearend, MONTH(e.dateend) AS monthend, e.datestart, e.dateend, e.text, m.id AS mediaId')
                        ->from( 'EasyMainBundle:Calendar',  'e' )
                        ->where('e.archive = false')
//                    ->Where(
//                        $qb->expr()->andX(
//                            $qb->expr()->between('e.dateStart', ':from', ':to')
//                        )
//                    )

                        //->join('e', 'media__media', 'm', 'e.media_id = m.id')
                        ->join('e.media','m')

                        //->groupBy('month')

                        ->orderBy('daystart', 'ASC')
                        ->orderBy('yearstart', 'DESC')
                        //->setFirstResult( $offset )
                        //->setMaxResults( $limit );
                    ;
                    $month = array();
                    $calendarItems = $qb->getQuery()->getResult();
                    foreach ($calendarItems as $itemIndex => $item) {
                        $media = $hp->getRepository('Application\Sonata\MediaBundle\Entity\Media')->find($item['mediaId']);
                        $calendarItems[$itemIndex]['media'] = $media;
                        switch($item['monthstart']){
                            case 1:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Январь';
                                break;
                            case 2:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Февраль';
                                break;
                            case 3:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Март';
                                break;
                            case 4:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Апрель';
                                break;
                            case 5:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Май';
                                break;
                            case 6:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Июнь';
                                break;
                            case 7:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Июль';
                                break;
                            case 8:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Август';
                                break;
                            case 9:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Сентябрь';
                                break;
                            case 10:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Октябрь';
                                break;
                            case 11:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Ноябрь';
                                break;
                            case 12:
                                $month[$item['yearstart']][$item['monthstart']]['content'][] = $calendarItems[$itemIndex];
                                $month[$item['yearstart']][$item['monthstart']]['monthRus'] = 'Декабрь';
                                break;
                        }
                        //date end
                        if($item['monthend'] != $item['monthstart']) {
                            switch ($item['monthend']) {
                                case 1:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Январь';
                                    break;
                                case 2:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Февраль';
                                    break;
                                case 3:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Март';
                                    break;
                                case 4:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Апрель';
                                    break;
                                case 5:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Май';
                                    break;
                                case 6:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Июнь';
                                    break;
                                case 7:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Июль';
                                    break;
                                case 8:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Август';
                                    break;
                                case 9:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Сентябрь';
                                    break;
                                case 10:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Октябрь';
                                    break;
                                case 11:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Ноябрь';
                                    break;
                                case 12:
                                    $month[$item['yearend']][$item['monthend']]['content'][] = $calendarItems[$itemIndex];
                                    $month[$item['yearend']][$item['monthend']]['monthRus'] = 'Декабрь';
                                    break;
                            }
                        }
                    }
                    foreach ($month as $yearKey => $year) {
                        $temp = $year;
                        ksort($temp);
                        $month[$yearKey] = $temp;
                    }

                    $foo = $this->render('EasyMainBundle:Block:block_calendar.html.twig', array(
                        'month'   => $month,
                        'content'   => $value,
                        'currentYear' => date("Y"),
                        'currentMonth' => date("m"),
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
            //'secondLayerMenu' => $secondLayerMenu,
            'teacherMenu' => $teacherMenu,
            'color' => $currentUrl->getColor(),
            'root' => $currentUrl->getId()
        ));
    }
    
    public function mainAction()
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $this->mainMenu();
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

        $mainMenu = $this->mainMenu();
        
        $news = $hp->getRepository('EasyMainBundle:News')->findBy(array("type" => "published"), array('order_column'=>'ASC'));

        $repository = $this->getDoctrine()->getRepository('EasyMainBundle:News');
        $query = $repository->createQueryBuilder('e')
            ->select('YEAR(e.date) AS year, e.type')
            ->where('e.type = :type')
            ->setParameter('type', 'archive')
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->getQuery()
        ;
        $archive = $query->getResult();

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
    public function newsArchiveShowAction($year)
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $this->mainMenu();

        //$news = $hp->getRepository('EasyMainBundle:News')->findBy(array("type" => "published", "date" => ''), array('order_column'=>'ASC'));
        // WHERE `date` LIKE '%2015%'

        $setParameter = array(
            'type' => 'archive',
            'year' => '%'.$year.'%'
        );
        $repository = $this->getDoctrine()->getRepository('EasyMainBundle:News');
        $query = $repository->createQueryBuilder('a')
            ->where('a.date LIKE :year')
            ->andWhere('a.type = :type')
            ->setParameters($setParameter)
            ->orderBy('a.date', 'DESC')
            ->getQuery();
        $news = $query->getResult();
        $archive = null;

        $topMenu = "";
        $secondLayerMenu = "";
        return $this->render('EasyMainBundle:Page:news_archive.html.twig', array(
            'mainMenu' => $mainMenu,
            'news' => $news,
            'archive' => $archive,
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'color' => 'salad',
            'year' => $year
        ));
    }
    
    public function easyTimesAction()
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $this->mainMenu();

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

        $mainMenu = $this->mainMenu();
        
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
        $mainMenu = $this->mainMenu();
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

        $mainMenu = $this->mainMenu();

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
            $mainMenu = $this->mainMenu();
            $content = $hp->getRepository('EasyMainBundle:Calendar')->findBy(array('archive' => 'false'), array('datestart' => 'DESC'));

            $repository = $this->getDoctrine()->getRepository('EasyMainBundle:Calendar');
            $query = $repository->createQueryBuilder('e')
                ->select('YEAR(e.datestart) AS year, e.archive')
                ->where('e.archive = true')
                ->groupBy('year')
                ->orderBy('year', 'DESC')
                ->getQuery()
            ;
            $archive = $query->getResult();

            $topMenu = "";
            $secondLayerMenu = "";

            return $this->render('EasyMainBundle:Block:block_calendar_all.html.twig', array(
                'mainMenu' => $mainMenu,
                'calendar' => $content,
                'archive' => $archive,
                'topMenu' => $topMenu,
                'secondLayerMenu' => $secondLayerMenu,
                'title' => 'Календарь событий',
                'color' => 'salad'
            ));
        }else{
            $hp = $this->getDoctrine()->getManager();

            $mainMenu = $this->mainMenu();

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

    public function calendarArchiveAction($year)
    {
        $hp = $this->getDoctrine()->getManager();

        $mainMenu = $this->mainMenu();

        $repository = $this->getDoctrine()->getRepository('EasyMainBundle:Calendar');
        $query = $repository->createQueryBuilder('a')
            ->where('YEAR(a.datestart) = :year')
            ->andWhere('a.archive = true')
            ->setParameter('year', $year)
            ->getQuery();
        $content = $query->getResult();


        $topMenu = "";
        $secondLayerMenu = "";
        return $this->render('EasyMainBundle:Block:block_calendar_all.html.twig', array(
            'mainMenu' => $mainMenu,
            'calendar' => $content,
            'archive' => '',
            'topMenu' => $topMenu,
            'secondLayerMenu' => $secondLayerMenu,
            'title' => 'Архив событий: '.$year,
            'color' => 'salad'
        ));

    }

    public function contactsAction($id)
    {
        $hp = $this->getDoctrine()->getManager();
        $mainMenu = $this->mainMenu();
        if($id == 'all'){
            
            $repository = $this->getDoctrine()->getRepository('EasyMainBundle:Contacts');
            $contacts = $repository->createQueryBuilder('cc')
                ->select()
                ->groupBy("cc.name")
                ->having("COUNT(cc.name) >= 1")
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
                //->groupBy('cc.coordinates')
                ->groupBy("cc.name")
                ->having("COUNT(cc.name) >= 1")
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
        $mainMenu = $this->mainMenu();
        $title = Stuff::getTypes();

        if($type == 'all'){
            $stuff = $hp->getRepository('EasyMainBundle:Stuff')->findAll();
            $all = 1;
        }else{
            $teacher = $hp->getRepository('EasyMainBundle:Stuff')->findBy(array('name' => $type));
            $stuff = $hp->getRepository('EasyMainBundle:Stuff')->findBy(array('type' => $type),array('name'=>'ASC'));
            if(!empty($teacher)){
                $stuff = $teacher;
                $all = 1;
            }elseif(!empty($stuff)){
                $stuff = $hp->getRepository('EasyMainBundle:Stuff')->findBy(array('type' => $type),array('name'=>'ASC'));
                $all = 0;
            }else{
                return $this->render('EasyMainBundle:Page:404.html.twig', array(
                    'mainMenu' => $mainMenu,
                    'topMenu' => '',
                    'color' => 'purple'
                ));
            }

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

    public function pageNotFoundAction()
    {
        $hp = $this->getDoctrine()->getManager();
        $mainMenu = $this->mainMenu();
        $topMenu = null;
        return $this->render('EasyMainBundle:Page:404.html.twig', array(
            'mainMenu' => $mainMenu,
            'topMenu' => $topMenu,
            'color' => 'purple'
        ));
    }

    // up down

    public function upAction($page_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('EasyMainBundle:MainMenu');
        $page = $repo->findOneById($page_id);
        if ($page->getParent()){
            $repo->moveUp($page);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }


    public function downAction($page_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('EasyMainBundle:MainMenu');
        $page = $repo->findOneById($page_id);
        if ($page->getParent()){
            $repo->moveDown($page);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function setMainNewsTrueAction($page_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('EasyMainBundle:News')->find($page_id);
        $repo->setMain(true);
        $em->flush();
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function setMainNewsFalseAction($page_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('EasyMainBundle:News')->find($page_id);
        $repo->setMain(false);
        $em->flush();
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}
