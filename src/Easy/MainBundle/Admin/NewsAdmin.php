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

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('media', 'sonata_type_model_list', array())
            ->add('type', 'choice', array('choices'=>array('published'=>'published','not published'=>'not published')))
            ->add('text', 'ckeditor', array(
                'config' => array(
                    'removePlugins' => 'htmldataprocessor'
                )
            ))
            ->add('order_column')
            ->add('date', 'date', array(
                'pattern' => 'dd MMM Y G',
                //'locale' => 'en',
                //'timezone' => 'Europe/Moscow',
            ))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('type')
            ->add('date')
            ->add('order_column')
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