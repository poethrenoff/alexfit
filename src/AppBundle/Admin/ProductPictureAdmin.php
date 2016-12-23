<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductPictureAdmin extends AbstractAdmin
{
    protected $parentAssociationMapping = 'picture_product';

    protected $datagridValues = array(
        '_sort_by' => 'picture_order',
        '_sort_order' => 'ASC',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $fileFieldOptions = array('required' => false, 'label' => 'Изображение');

        if (($image = $this->getSubject()) && ($webPath = $image->getPictureImage())) {
            $fileFieldOptions['help'] = '<img src="' . $webPath . '" style="max-width: 150px; max-height: 150px" />';
        }

        $formMapper
            ->add('picture_product', 'entity', array(
                'class' => 'AppBundle\Entity\Product',
                'label' => 'Товар'
            ))
            ->add('file', 'file', $fileFieldOptions)
            ->add('picture_order', 'integer', array('label' => 'Порядок'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('picture_product', null, array('label' => 'Товар'))
            ->add('picture_image', null, array('label' => 'Изображение'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('picture_id', null, array('label' => 'ID'))
            ->add('picture_product', null, array('label' => 'Товар'))
            ->addIdentifier('picture_image', null, array('label' => 'Изображение'))
            ->add('picture_order', null, array('label' => 'Порядок', 'editable' => true));
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    public function manageFileUpload($image)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $image->setUploadDirectory($container->getParameter('product_picture_upload_directory'));
        $image->setUploadAlias($container->getParameter('product_picture_upload_alias'));

        $image->upload();
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\ProductPicture ?
            $object->getPictureImage() :
            'Новое изображение';
    }

}
