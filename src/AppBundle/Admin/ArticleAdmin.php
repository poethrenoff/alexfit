<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class ArticleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('article_title', 'text', array('label' => 'Название'))
            ->add('article_announce', 'textarea', array('label' => 'Анонс', 'attr' => array('class' => 'editor')))
            ->add('article_text', 'textarea', array('label' => 'Текст', 'attr' => array('class' => 'editor')))
            ->add('article_active', 'checkbox', array('label' => 'Видимость', 'required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('article_title', null, array('label' => 'Название'))
            ->add('article_text', null, array('label' => 'Текст'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('article_id', null, array('label' => 'ID'))
            ->addIdentifier('article_title', null, array('label' => 'Название'))
            ->add('article_active', null, array('label' => 'Видимость', 'editable' => true));
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('article_announce')
                ->assertNotBlank()
            ->end()
            ->with('article_text')
                ->assertNotBlank()
            ->end();
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Article
            ? $object->getArticleTitle()
            : 'Новая статья';
    }
}