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
        $subject = $this->getSubject();
        if($subject->getId() == NULL){
            $archive = false;
        }else{
            $archive = $subject->getArchive();
        }

        $formMapper
            ->add('name', 'text', array('label' => 'Название'))
            ->add('text', 'ckeditor', array(
                'config' => array(
                    'removePlugins' => 'htmldataprocessor'
                ),
                'label' => 'Описание'
            ))
            ->add('datestart', 'sonata_type_date_picker', array(
                    'label' => 'Дата начала события',
                    'format'=>'dd/MM/yyyy',

                )
            )
            ->add('dateend', 'sonata_type_date_picker', array(
                    'label' => 'Дата окончания события',
                    'format'=>'dd/MM/yyyy',
                    'required' => false,

                )
            )
            ->add('archive', 'checkbox', array('data'=>$archive, 'required' => false, 'label' => 'Архив'))
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