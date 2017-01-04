<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TextAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text_tag', 'text', array('label' => 'Метка'))
            ->add('text_title', 'text', array('label' => 'Заголовок'))
            ->add('text_content', 'textarea', array('label' => 'Текст', 'attr' => array('class' => 'ckeditor')));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('text_tag', null, array('label' => 'Метка'))
            ->add('text_title', null, array('label' => 'Заголовок'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('text_id', null, array(
                'label' => 'ID',
                'header_style' => 'width: 10%'
            ))
            ->add('text_tag', null, array('label' => 'Метка'))
            ->addIdentifier('text_title', null, array('label' => 'Заголовок'));
    }
    
    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Text
            ? $object->getTextTitle()
            : 'Новый текст';
    }
}