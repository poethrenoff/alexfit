<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CatalogueAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_sort_by' => 'catalogue_order',
        '_sort_order' => 'ASC',
    );
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('catalogue_title', 'text', array('label' => 'Название'))
            ->add('catalogue_name', 'text', array('label' => 'Ссылка'))
            ->add('catalogue_description', 'textarea', array('label' => 'Описание', 'required' => false))
            ->add('catalogue_order', null, array('label' => 'Порядок'))
            ->add('catalogue_active', null, array('label' => 'Видимость'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('catalogue_title', null, array('label' => 'Название'))
            ->add('catalogue_active', null, array('label' => 'Видимость'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('catalogue_id', null, array('label' => 'ID'))
            ->addIdentifier('catalogue_title', null, array('label' => 'Название'))
            ->add('catalogue_name', null, array('label' => 'Ссылка'))
            ->add('catalogue_order', null, array('label' => 'Порядок', 'editable' => true))
            ->add('catalogue_active', null, array('label' => 'Видимость', 'editable' => true))
            ->add('_action', 'actions', array(
                'label' => 'Операции',
                'actions' => array(
                    'category' => array('template' => 'AppBundle::category.html.twig')
                )));
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Catalogue
            ? $object->getCatalogueTitle()
            : 'Новая группа';
    }
}