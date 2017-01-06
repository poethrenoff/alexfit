<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use AppBundle\Admin\UploadTrait;
use AppBundle\Lib\Transliterator;

class CategoryAdmin extends AbstractAdmin
{
    use UploadTrait;
    
    protected $parentAssociationMapping = 'category_catalogue';

    protected $datagridValues = array(
        '_sort_by' => 'category_order',
        '_sort_order' => 'ASC',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $pictureOptions = array('label' => 'Изображение', 'data_class' => null);
        if (($subject = $this->getSubject()) && ($webPath = $subject->getCategoryPicture())) {
            $pictureOptions['help'] = '<img src="' . $webPath . '" style="max-width: 150px; max-height: 150px" />';;
            $pictureOptions['required'] = false;
        }
        
        $formMapper
            ->add('category_catalogue', 'entity', array(
                'class' => 'AppBundle\Entity\Catalogue',
                'label' => 'Группа'
            ))
            ->add('category_title', 'text', array('label' => 'Название'))
            ->add('category_short_title', 'text', array('label' => 'Краткое название'));
        
        if (($category = $this->getSubject()) && !empty($category->getCategoryName())) {
            $formMapper
                ->add('category_name', 'text', array('label' => 'Ссылка'));
        }
        
        $formMapper
            ->add('category_description', 'textarea', array('label' => 'Описание', 'required' => false, 'attr' => array('class' => 'editor')))
            ->add('category_picture_file', 'file', $pictureOptions)
            ->add('category_order', 'integer', array('label' => 'Порядок'))
            ->add('category_active', 'checkbox', array('label' => 'Видимость', 'required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('category_catalogue', null, array('label' => 'Группа'))
            ->add('category_title', null, array('label' => 'Название'))
            ->add('category_active', null, array('label' => 'Видимость'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('category_id', null, array('label' => 'ID'))
            ->add('category_catalogue', null, array('label' => 'Группа'))
            ->addIdentifier('category_title', null, array('label' => 'Название'))
            ->add('category_name', null, array('label' => 'Ссылка'))
            ->add('category_order', null, array('label' => 'Порядок', 'editable' => true))
            ->add('category_active', null, array('label' => 'Видимость', 'editable' => true))
            ->add('_action', 'actions', array(
                'label' => 'Операции',
                'actions' => array(
                    'product' => array('template' => 'AppBundle::Admin/product.html.twig')
                )));
    }
    
    public function configureUploadFields()
    {
        $container = $this->getConfigurationPool()->getContainer();
        
        $this
            ->addUploadField('category_picture', array(
                'target_field' => 'CategoryPicture', 'file_field' => 'CategoryPictureFile',
                'upload_directory' => $container->getParameter('category_upload_directory'),
                'upload_alias' => $container->getParameter('category_upload_alias'),
            ));
    }
    
    public function prePersist($object)
    {
        parent::prePersist($object);
        
        if (empty($object->getCategoryName())) {
            $object->setCategoryName(Transliterator::transliterate($object->getCategoryShortTitle()));
        }
                
        $this->manageFileUpload($object);
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);
        
        if (empty($object->getCategoryName())) {
            $object->setCategoryName(Transliterator::transliterate($object->getCategoryShortTitle()));
        }
                
        $this->manageFileUpload($object);
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Category
            ? $object->getCategoryTitle()
            : 'Новая группа';
    }
}