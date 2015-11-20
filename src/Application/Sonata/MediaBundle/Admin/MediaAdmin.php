<?php
namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Provider\Pool;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Sonata\MediaBundle\Admin\BaseMediaAdmin as BaseMediaAdmin;


class MediaAdmin extends BaseMediaAdmin
{

    /**
    * {@inheritdoc}
    */
    /*protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('custom', 'string', array('template' =>  'SonataMediaBundle:MediaAdmin:list_custom.html.twig'))
            ->add('enabled', 'boolean', array('editable' => true))
            ->add('_action', 'actions', array(
                'actions' => array(
                'view' => array(),
                'edit' => array(),
                'delete' => array(),
            )
        ))
    ;
    }*/
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                //dump($this->getForm()->getData()->getProviderName(), $name);die();
                if($this->getForm()->getData()->getProviderName() == "sonata.media.provider.custom"){
                    return 'ApplicationSonataMediaBundle:MediaAdmin:custom_edit.html.twig';
                }else{
                    return parent::getTemplate($name);
                }
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $media = $this->getSubject();

        if (!$media) {
            $media = $this->getNewInstance();
        }

        if (!$media || !$media->getProviderName()) {
            return;
        }

        $formMapper->getFormBuilder()->addModelTransformer(new ProviderDataTransformer($this->pool, $this->getClass()), true);

        $provider = $this->pool->getProvider($media->getProviderName());
        //dump($formMapper, $provider);die();
        //$formMapper->remove('binaryContent');
        if ($media->getId()) {
            $provider->buildEditForm($formMapper);
        } else {
            $provider->buildCreateForm($formMapper);
        }
    }

}