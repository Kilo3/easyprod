<?php

namespace Easy\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
//use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
//use Doctrine\ORM\EntityRepository;
//use Sonata\MediaBundle\Entity\Gallery;
use Easy\MainBundle\Entity\Content;
use Easy\MainBundle\Entity\Stuff;
use Sonata\AdminBundle\Route\RouteCollection;




use Symfony\Component\Form\AbstractType;
/*use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;*/
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/*use Symfony\Component\Form\FormInterface;*/
 
class ContentAdmin extends Admin
{
    // setup the default sort column and order
//    protected $datagridValues = array(
//        '_sort_order_column' => 'ASC',
//        '_sort_by' => 'id'
//    );
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Общая информация', array('class' => 'col-md-6'))
                ->add('type', 'choice', array('choices' => Content::getTypes(), 'expanded' => false, 'label'=> 'Тип блока'))
                ->add('name', 'text', array('label' => 'Название'))
                ->add('link', 'text', array('label' => 'Ссылка с названия', 'required' => false))
            ->end();

        $subject = $this->getSubject();

        if($subject->getId() == NULL){
            $horizontal = false;
        }else{
            $horizontal = $subject->getHorizontal();
        }
        switch ($subject->getType()) {
            case 'gallery':
                $formMapper
                    ->with('Взаимосвязь', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                            'btn_add' => false,
                            'label' => 'Блок расположен на странице'
                        ))
                        ->add('order_column', 'integer', array('label' => 'Порядок', 'help' => 'Чем меньше, тем выше на странице будет расплоложено содержимое'))
                        ->add('gallery','sonata_type_model_list',array(
                            'btn_add' => false,
                            'label' => 'Галерея'
                        ))
                        ->add('horizontal', 'checkbox', array('data'=>$horizontal, 'required' => false, 'label' => 'Горизонтальное ориентирование блока'))
                    ->end()
                    ->with('Контент', array('class' => 'col-md-12'))
                        ->add('content', 'ckeditor',array('config_name' => 'default', 'label' => 'Текст'))
                    ->end();
                break;
            case 'video':
            case 'content':
                $formMapper
                    ->with('Взаимосвязь', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                                'btn_add' => false,
                                'label' => 'Блок расположен на странице'
                              ))
                        ->add('order_column', 'integer', array('label' => 'Порядок', 'help' => 'Чем меньше, тем выше на странице будет расплоложено содержимое'))
                        ->add('gallery','sonata_type_model_list',array(
                            'btn_add' => false,
                            'label' => 'Галерея'
                        ))
                    ->end()
                    ->with('Контент', array('class' => 'col-md-12'))
                        ->add('content', 'ckeditor',array('config_name' => 'default', 'label' => 'Текст'))
                    ->end();
                break;
            
            case 'slider':
                $formMapper
                    ->with('General', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                                'btn_add' => false
                              ))
                        
                        ->add('order_column')
                    ->end()
                    ->with('Slider', array('class' => 'col-md-12'))
                        ->add('teams', 'sonata_type_collection', array(
                            'by_reference'       => false,
                            'cascade_validation' => true,
                        ), array(
                            'edit' => 'inline',
                            'inline' => 'table'
                        ))
                    ->end();
                break;
            case 'photo':
            case 'video_gallery':
                $formMapper
                    ->with('General', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                                'btn_add' => false
                              ))
                        
                        ->add('order_column')
                        ->add('gallery','sonata_type_model_list',array(
                            'btn_add' => false
                        ))
                    ->end();
                break;
            case 'contacts':
                $formMapper
                    ->with('General', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                                'btn_add' => false
                              ))
                        
                        ->add('order_column')
                    ->end()
                    ->with('Contacts', array('class' => 'col-md-12'))
                        ->add('contacts', 'sonata_type_collection', array(
                            'by_reference'       => false,
                            'cascade_validation' => true,
                        ), array(
                            'edit' => 'inline',
                            'inline' => 'standard'
                        ))
                    ->end();
                break;
            
            case 'stuff':
                $formMapper
                    ->with('General', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                                'btn_add' => false
                              ))

                        ->add('order_column')
                        ->add('stuff', 'choice', array('choices' => Stuff::getTypes(), 'expanded' => true))
                    ->end();
                break;

            case 'news':
                $formMapper
                    ->with('General', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                            'btn_add' => false
                        ))
                        ->add('order_column')
                    ->end();
                break;
            case 'photo_links':
                $formMapper
                    ->with('General', array('class' => 'col-md-6'))
                        ->add('url','sonata_type_model_list',array(
                            'btn_add' => false
                        ))
                        ->add('order_column')
                    ->end();
                break;
            default:
                break;
        }
        
        //выбор меню второго уровня если есть контент для этого
        //if ($subject->getUrl() != null && count($subject->getUrl()->getChildren()) > 1) {
        /*if ($subject->getUrl() != null) {
            $choices = array();
            //dump();die();
            foreach($subject->getUrl()->getChildren() as $index => $value){
                $choices[$value->getId()] = $value->getTitle();
            }
            if(count($choices)>1){
                $choices[0] = 'Все меню';
            }
            $choices[-1] = 'Отключить';
            $formMapper
                ->with('secondMenu', array('class' => 'col-md-6'))
                    ->add('second_menu', 'choice', array('choices' => $choices, 'expanded' => true))
                ->end();
        }*/
        
        
        // работает норм только после update
        
        
                
                //$em = $this->modelManager->getEntityManager('Application\Sonata\MediaBundle\Entity\Gallery');
        //$currentUrl = $em->getRepository('SonataMediaBundle:Gallery')->findAll();
        //$currentUrl = $em->getRepository('ApplicationSonataMediaBundle:Gallery')->findOneBy(array('id'=>4));
        //echo "<pre>";var_dump($currentUrl);die();
            //->add('gallery_id', 'sonata_type_model_list', array('class' => 'Sonata\MediaBundle\Entity\Gallery'), array('placeholder' => 'qweqwe'))
                
            //->add('gallery_id', 'choice', array('choices' => $this->getGalleries(), 'expanded' => true))
                
//            ->add('media', 'sonata_media_type', array(
//                 'provider' => 'sonata.media.provider.image',
//                 'context'  => 'engine'
//            ));
        
        
//        $subject = $this->getSubject();
//
//        if ($subject->isNew()) {
//            // The thumbnail field will only be added when the edited item is created
//            $formMapper->add('thumbnail', 'file');
//        }
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('url')
            ->add('name')
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('name', null,  array('label' => 'Название'))
            ->add('url', 'string', array('label' => 'Страница'))
            ->add('order_column', null, array('label' => 'Порядок следования'))
            
            
//            ->add('_action', 'actions', array(
//                'actions' => array(
//                    'Clone' => array(
//                        'template' => 'EasyMainBundle:CRUD:list__action_clone.html.twig'
//                    )
//                )
//            ))
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
        
//        $collection->add('myCustomAction');
//        $collection->add('view', $this->getRouterIdParameter().'/view');
    }
    
//    public function prePersist($content)
//    {
//        foreach ($content->getTeam() as $team) {
//            $team->setTeam($team);
//        }
//    }
//
    public function preUpdate($content)
    {
        //dump($content->getSecondMenu());die();
//        if($content->getSecondMenu()) {
//            $content;
//        }
        //$content->addTeam($content->getTeams());
    }
    
    
}