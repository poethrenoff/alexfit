<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use AppBundle\Admin\UploadTrait;

class ProductAdmin extends AbstractAdmin
{
    use UploadTrait;
    
    protected $parentAssociationMapping = 'product_category';
    
    protected $datagridValues = array(
        '_sort_by' => 'product_title',
        '_sort_order' => 'asc',
    );
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $instructionOptions = array('label' => 'Инструкция', 'data_class' => null, 'required' => false);
        if (($product = $this->getSubject()) && ($webPath = $product->getProductInstruction())) {
            $instructionOptions['help'] = $webPath;
        }
        
        $formMapper
            ->add('product_category', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
                'label' => 'Категория'
            ))
            ->add('product_brand', 'entity', array(
                'class' => 'AppBundle\Entity\Brand',
                'label' => 'Производитель'
            ))
            ->add('product_title', 'text', array('label' => 'Название'))
            ->add('product_price', 'integer', array('label' => 'Цена'))
            ->add('product_price_old', 'integer', array('label' => 'Старая цена'))
            ->add('product_short_description', 'textarea', array('label' => 'Краткое описание', 'required' => false))
            ->add('product_full_description', 'textarea', array('label' => 'Подробное описание', 'required' => false, 'attr' => array('class' => 'editor')))
            ->add('product_instruction_file', 'file', $instructionOptions)
            ->add('product_active', 'checkbox', array('label' => 'Видимость', 'required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('product_brand', null, array('label' => 'Производитель'))
            ->add('product_title', null, array('label' => 'Название'))
            ->add('product_active', null, array('label' => 'Видимость'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('product_id', null, array('label' => 'ID'))
            ->add('product_category', null, array('label' => 'Категория'))
            ->add('product_brand', null, array('label' => 'Производитель'))
            ->addIdentifier('product_title', null, array('label' => 'Название'))
            ->add('product_price', null, array('label' => 'Цена', 'editable' => true))
            ->add('product_price_old', null, array('label' => 'Старая цена', 'editable' => true))
            ->add('product_active', null, array('label' => 'Видимость', 'editable' => true))
            ->add('_action', 'actions', array(
                'label' => 'Операции',
                'actions' => array(
                    'product_picture' => array('template' => 'AppBundle::Admin/product_picture.html.twig')
                )));
    }
    
    public function configureUploadFields()
    {
        $container = $this->getConfigurationPool()->getContainer();
        
        $this
            ->addUploadField('product_instruction', array(
                'target_field' => 'ProductInstruction', 'file_field' => 'ProductInstructionFile',
                'upload_directory' => $container->getParameter('instruction_upload_directory'),
                'upload_alias' => $container->getParameter('instruction_upload_alias'),
            ));
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Product
            ? $object->getProductTitle()
            : 'Новый товар';
    }
}