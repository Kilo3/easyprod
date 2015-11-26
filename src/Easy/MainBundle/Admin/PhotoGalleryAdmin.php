<?php
namespace Easy\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Easy\MainBundle\Entity\Stuff;

class PhotoGalleryAdmin extends Admin
{
    
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name','text',array('label' => 'Название'))
            ->add('gallery','sonata_type_model_list',array('label' => 'Привязанная галерея'))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Название'))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }
}