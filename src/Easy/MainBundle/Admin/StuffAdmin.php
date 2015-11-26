<?php
namespace Easy\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Easy\MainBundle\Entity\Stuff;

class StuffAdmin extends Admin
{
    
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('type')
            
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Иия'))
            ->add('text', 'ckeditor',array('config_name' => 'default', 'label' => 'Описание'))
            ->add('type', 'choice', array('choices' => Stuff::getTypes(), 'expanded' => true, 'label'=> 'Тип'))
            ->add('media','sonata_type_model_list',array('label' => 'Фотография'))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Имя'))
            ->add('type', null, array('label' => 'Тип'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            //->add('category')
        ;
    }
}