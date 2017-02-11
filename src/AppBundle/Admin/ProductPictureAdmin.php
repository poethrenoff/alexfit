<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use AppBundle\Admin\UploadTrait;

class ProductPictureAdmin extends AbstractAdmin
{
    use UploadTrait;
    
    protected $parentAssociationMapping = 'picture_product';

    protected $datagridValues = array(
        '_sort_by' => 'picture_order',
        '_sort_order' => 'ASC',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $imageFileOptions = array('label' => 'Изображение', 'required' => false);
        $imageOptions = array('label' => 'Изображение (url)', 'required' => false);
        if (($subject = $this->getSubject()) && ($webPath = $subject->getPictureImage())) {
            $imageOptions['help'] = '<img src="' . $webPath . '" style="max-width: 150px; max-height: 150px" />';
        }

        $formMapper
            ->add('picture_product', 'entity', array(
                'class' => 'AppBundle\Entity\Product',
                'label' => 'Товар'
            ))
            ->add('picture_image_file', 'file', $imageFileOptions)
            ->add('picture_image', 'text', $imageOptions)
            ->add('picture_order', 'integer', array('label' => 'Порядок'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('picture_id', null, array('label' => 'ID'))
            ->add('picture_product', null, array('label' => 'Товар'))
            ->addIdentifier('picture_image', null, array('label' => 'Изображение'))
            ->add('picture_order', null, array('label' => 'Порядок', 'editable' => true));
    }
    
    public function configureUploadFields()
    {
        $container = $this->getConfigurationPool()->getContainer();
        
        $this
            ->addUploadField('picture_image', array(
                'target_field' => 'PictureImage', 'file_field' => 'PictureImageFile',
                'upload_directory' => $container->getParameter('product_picture_upload_directory'),
                'upload_alias' => $container->getParameter('product_picture_upload_alias'),
            ));
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\ProductPicture ?
            $object->getPictureImage() :
            'Новое изображение';
    }
}
