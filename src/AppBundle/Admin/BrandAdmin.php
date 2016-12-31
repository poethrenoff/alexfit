<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BrandAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('brand_title', 'text', array('label' => 'Название'))
            ->add('brand_country', 'text', array('label' => 'Страна', 'required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('brand_title', null, array('label' => 'Название'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('brand_id', null, array('label' => 'ID'))
            ->addIdentifier('brand_title', null, array('label' => 'Название'))
            ->add('brand_country', null, array('label' => 'Страна'));
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Product
            ? $object->getProductTitle()
            : 'Новый производитель';
    }
}