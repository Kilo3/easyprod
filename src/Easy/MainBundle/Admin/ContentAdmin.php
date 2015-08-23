<?php

namespace Easy\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;
//use Sonata\MediaBundle\Entity\Gallery;
use Easy\MainBundle\Entity\Content;
use Sonata\AdminBundle\Route\RouteCollection;
 
class ContentAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order_column' => 'ASC',
        '_sort_by' => 'id'
    );
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        
        
//        $builder = $formMapper->getFormBuilder();
//        
//        
//        
//        
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            $product = $event->getData();
//
//            if ($product && $product->getType() == 'gallery') {
//                $form->add('gallery');
//            }else{
//                $form->add('name');
//            }
//        });
        
//        $subject = $this->getSubject();
//        //dump($subject);die();
//        if ($subject->getType() == 'gallery') {
//            // The thumbnail field will only be added when the edited item is created
//            $formMapper->add('gallery');
//        }
        
        
        
        $formMapper
            ->with('Important', array('class' => 'col-md-6'))
                ->add('type', 'choice', array('choices' => Content::getTypes(), 'expanded' => true))
                ->add('name')
            ->end()
            ->with('General', array('class' => 'col-md-6'))
                ->add('url')
                ->add('top_menu', null, array('required' => false))
                ->add('order_column')
                ->add('gallery')
            ->end()
            ->with('Content', array('class' => 'col-md-12'))
                ->add('content', 'ckeditor',array('config_name' => 'default'))
            ->end()
                
            
        ;   
        
        $subject = $this->getSubject();
        //выбор меню второго уровня если есть контент для этого
        if ($subject->getUrl() != null && count($subject->getUrl()->getChildren()) > 1) {
            $choices = array();
            foreach($subject->getUrl()->getChildren() as $index => $value){
                $choices[$index+1] = $value->getTitle();
            }
            $formMapper
                ->with('secondMenu', array('class' => 'col-md-6'))
                    ->add('second_menu', 'choice', array('choices' => $choices, 'expanded' => true))
                ->end();
        }
        
        if ($subject->getType() == 'slider') {
            $formMapper
                ->with('Slider', array('class' => 'col-md-12'))
                    ->add('teams', 'sonata_type_collection', array(
                        'by_reference'       => false,
                        'cascade_validation' => true,
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table'
                    ))
                ->end();
        }
        
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
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('url', 'string')
            ->add('top_menu')
            ->add('order_column')
            
            
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