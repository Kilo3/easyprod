<?php
namespace Easy\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Easy\MainBundle\Entity\MainMenu;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class MainMenuAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_by'    => 'root',
        '_sort_by'    => 'lft',
        '_sort_order' => 'ASC'
    );

    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager('Easy\MainBundle\Entity\MainMenu');

        $queryBuilder = $em
            ->createQueryBuilder('p')
            ->select('p')
            ->from('EasyMainBundle:MainMenu', 'p')
            ->where('p.parent IS NOT NULL')
        ;

        $query = new ProxyQuery($queryBuilder);
        return $query;
    }


    public function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();
        if($subject->getId() == NULL){
            $enabled = true;
        }else{
            $enabled = $subject->getEnabled();
        }

        $formMapper
            ->with('General', array('class' => 'col-md-12'))
                ->add('url')
                ->add('title')
                ->add('order_column')
                ->add('enabled', 'checkbox', array('data'=>$enabled, 'required' => false))
                ->add('color', 'choice', array('choices'=> MainMenu::getColors(), 'expanded' => false))
                ->add('seo_title')
                ->add('seo_description')
                /*->add('parent','sonata_type_model_list',array(
                    'btn_add' => false
                ))*/
                ->add('parent', 'sonata_type_model_list', array(
                    'label' => 'Родитель',
                    'required'=>true,
                    'btn_add' => false,
                    'btn_delete' => false,
                ))
            ->end()
        ;

        /*->add('parent','sonata_type_model_list',array(
            'btn_add' => false
        ))*/
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('sortable'=>false))
            ->addIdentifier('laveled_title', null, array('sortable'=>false, 'label'=>'Название страницы'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array('template' => 'EasyMainBundle:Admin/CRUD:list__action_entity_board.html.twig'),
                )
            ))

        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }


    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($object);
        $repo = $em->getRepository("EasyMainBundle:MainMenu");
        $repo->verify();
        $repo->recover();
        $em->flush();
    }

    public function postUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($object);
        $repo = $em->getRepository("EasyMainBundle:MainMenu");
        $repo->verify();
        $repo->recover();
        $em->flush();
    }

    /*protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('dummy',
                'dummy/{id}',
                array('_controller' => 'EasyMainBundle:Default:dummy'),
                array('id' => '\d+')
            )
        ;
    }*/


}