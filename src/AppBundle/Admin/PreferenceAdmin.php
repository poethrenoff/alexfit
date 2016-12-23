<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PreferenceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('preference_title', 'text', array('label' => 'Название'))
            ->add('preference_name', 'text', array('label' => 'Ключ'))
            ->add('preference_value', 'text', array('label' => 'Значение'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('preference_title', null, array('label' => 'Название'))
            ->add('preference_name', null, array('label' => 'Ключ'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('preference_id', null, array('label' => 'ID'))
            ->addIdentifier('preference_title', null, array('label' => 'Название'))
            ->add('preference_name', null, array('label' => 'Ключ'))
            ->add('preference_value', null, array('label' => 'Значение'));
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Article
            ? $object->getArticleTitle()
            : 'Новое свойство';
    }
}