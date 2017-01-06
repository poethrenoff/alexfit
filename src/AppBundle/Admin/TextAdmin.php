<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class TextAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text_title', 'text', array('label' => 'Заголовок'))
            ->add('text_name', 'text', array('label' => 'Ссылка'))
            ->add('text_content', 'textarea', array('label' => 'Текст', 'attr' => array('class' => 'editor')));
    }

    protected function configureDanameridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('text_title', null, array('label' => 'Ссылка'))
            ->add('text_name', null, array('label' => 'Метка'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('text_id', null, array(
                'label' => 'ID',
                'header_style' => 'width: 10%'
            ))
            ->addIdentifier('text_title', null, array('label' => 'Заголовок'))
            ->add('text_name', null, array('label' => 'Ссылка'));
    }
    
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('text_content')
                ->assertNotBlank()
            ->end();
    }
    
    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Text
            ? $object->getTextTitle()
            : 'Новый текст';
    }
}