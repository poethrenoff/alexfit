<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class PurchaseItemAdmin extends AbstractAdmin
{
    protected $parentAssociationMapping = 'item_purchase';
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('item_purchase', 'entity', array(
                'class' => 'AppBundle\Entity\Purchase',
                'label' => 'Производитель'
            ))
            ->add('item_product', 'entity', array(
                'class' => 'AppBundle\Entity\Product',
                'label' => 'Производитель'
            ))
            ->add('item_price', 'integer', array('label' => 'Email'))
            ->add('item_quantity', 'integer', array('label' => 'Телефон'));
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('item_id', null, array('label' => 'ID'))
            ->addIdentifier('item_purchase', null, array('label' => 'Заказ'))
            ->add('item_product', null, array('label' => 'Товар'))
            ->add('item_price', null, array('label' => 'Цена', 'editable' => true))
            ->add('item_quantity', null, array('label' => 'Количество', 'editable' => true))
            ->add('_action', 'actions', array(
                'label' => 'Операции',
                'actions' => array(
                    'edit' => array(),
                    'delete' => array()
                )));
    }
    
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    
    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\PurchaseItem
            ? $object->getItemId()
            : 'Новая позиция';
    }
}