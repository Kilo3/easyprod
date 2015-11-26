<?php
namespace Easy\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CalendarAdmin extends Admin
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
            ->add('name', 'text', array('label' => 'Название'))
            ->add('text', 'ckeditor', array(
                'config' => array(
                    'removePlugins' => 'htmldataprocessor'
                ),
                'label' => 'Описание'
            ))
            ->add('date', 'date', array(
                'pattern' => 'dd MMM Y G',
                //'locale' => 'en',
                //'timezone' => 'Europe/Moscow',
                'label' => 'Дата события'
                )
            )
           ->add('media', 'sonata_type_model_list', array('label' => 'Превью картинка'))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Название'))
            ->add('date', null, array('label' => 'Дата события'))
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