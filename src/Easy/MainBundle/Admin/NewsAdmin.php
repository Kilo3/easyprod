<?php
namespace Easy\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NewsAdmin extends Admin
{
    protected $parentAssociationMapping = 'content';

    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id',
    );

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Название'))
            ->add('media', 'sonata_type_model_list', array('label' => 'Превью картинка'))
            ->add('type', 'choice', array('choices'=>array('published'=>'Опубликовано','not published'=>'Не опубликовано','archive' => 'В архиве'), 'label' => 'Состояние'))
            ->add('text', 'ckeditor', array(
                'config' => array(
                    'removePlugins' => 'htmldataprocessor'
                ),
                'label' => 'Текст новости'
            ))
            ->add('order_column', 'integer', array('label' => 'Порядок отображения'))
            ->add('main', 'checkbox', array('label' => 'Важные', 'required' => false))
            ->add('date', 'date', array(
                'pattern' => 'dd MMM Y G',
                //'locale' => 'en',
                //'timezone' => 'Europe/Moscow',
                'label' => 'Дата новости'
            ))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Название'))
            ->add('type', null, array('label' => 'Тип'))
            ->add('date', null, array('label' => 'Дата'))
            ->add('order_column', null, array('label' => 'Порядок'))
            ->add('set_main', 'boolean', array('template' => 'EasyMainBundle:Admin:set_main_news.html.twig', 'label'=>'Важные'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('name')
            //->add('category')
        ;
    }
}