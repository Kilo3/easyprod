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

/*    public function createQuery($context = 'list')
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
    }*/


    public function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();
        if($subject->getId() == NULL){
            $enabled = true;
            $empty = false;
            $record = false;
        }else{
            $enabled = $subject->getEnabled();
            $empty = $subject->getEmpty();
            $record = $subject->getRecord();
        }

        if($subject->getLvl() == 1){
            $formMapper
                ->with('General', array('class' => 'col-md-12'))
                ->add('url', 'text', array('label' => 'Адрес страницы'))
                ->add('title', 'text', array('label' => 'Название страницы'))
                ->add('title_menu', 'text', array('label' => 'Название в меню слева. Только для страниц первого уровня'))
                ->add('enabled', 'checkbox', array('data'=>$enabled, 'required' => false, 'label' => 'Отображение в меню'))
                ->add('empty', 'checkbox', array('data'=>$empty, 'required' => false, 'label' => 'Скрыть с сайта'))
                ->add('color', 'choice', array('choices'=> MainMenu::getColors(), 'expanded' => false, 'label' => 'Цвет'))
                ->add('seo_title', 'text', array('label' => 'СЕО заголовок страницы'))
                ->add('seo_description', 'text', array('label' => 'СЕО описание страницы'))
                ->add('seo_keywords', 'text', array('label' => 'СЕО ключевые слова'))
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
                ->with('Специфические атрибуты', array('class' => 'col-md-12'))
                ->add('record', 'checkbox', array('data'=>$record, 'required' => false, 'label' => 'Этот раздел только вызывает форму Записаться в меню'))
                ->add('link', 'text', array('label' => 'Внешняя ссылка', 'required' => false))
                ->end()
            ;

        }else{
            $formMapper
                ->with('General', array('class' => 'col-md-12'))
                ->add('url', 'text', array('label' => 'Адрес страницы'))
                ->add('title', 'text', array('label' => 'Название страницы'))
                ->add('enabled', 'checkbox', array('data'=>$enabled, 'required' => false, 'label' => 'Отображение в меню'))
                ->add('empty', 'checkbox', array('data'=>$empty, 'required' => false, 'label' => 'Скрыть с сайта'))
                ->add('color', 'choice', array('choices'=> MainMenu::getColors(), 'expanded' => false, 'label' => 'Цвет'))
                ->add('seo_title', 'text', array('label' => 'СЕО заголовок страницы'))
                ->add('seo_description', 'text', array('label' => 'СЕО описание страницы'))
                ->add('seo_keywords', 'text', array('label' => 'СЕО ключевые слова'))
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
                ->with('Специфические атрибуты', array('class' => 'col-md-12'))
                ->add('record', 'checkbox', array('data'=>$record, 'required' => false, 'label' => 'Этот раздел только вызывает форму Записаться в меню'))
                ->add('link', 'text', array('label' => 'Внешняя ссылка', 'required' => false))
                ->end()
            ;
        }


        /*->add('parent','sonata_type_model_list',array(
            'btn_add' => false
        ))*/
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('sortable'=>false))
            ->add('up', 'text', array('template' => 'EasyMainBundle:Admin:field_tree_up.html.twig', 'label'=>' '))
            ->add('down', 'text', array('template' => 'EasyMainBundle:Admin:field_tree_down.html.twig', 'label'=>' '))
            ->addIdentifier('leveled_title', null, array('sortable'=>false, 'label'=>'Название страницы'))
            ->add('leveled_url', null, array('label' => 'Адрес страницы'))
            ->add('enabled', null, array('sortable'=>false, 'label'=>'Отображение в меню'))
            ->add('empty', null, array('sortable'=>false, 'label'=>'Скрыт с сайта'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array('template' => 'EasyMainBundle:Admin/CRUD:list__action_entity_board.html.twig'),
                ),
                'label' => 'Содержимое страницы'
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