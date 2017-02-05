<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class PurchaseAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_sort_by' => 'purchase_date',
        '_sort_order' => 'DESC',
    );
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('purchase_person', 'text', array('label' => 'ФИО'))
            ->add('purchase_email', 'text', array('label' => 'Email'))
            ->add('purchase_phone', 'text', array('label' => 'Телефон'))
            ->add('purchase_address', 'textarea', array('label' => 'Адрес'))
            ->add('purchase_comment', 'textarea', array('label' => 'Комментарий', 'required' => false))
            ->add('purchase_date', 'datetime', array('label' => 'Дата'))
            ->add('purchase_sum', 'integer', array('label' => 'Сумма'))
            ->add('purchase_status', 'choice', array('label' => 'Статус', 'choices' => array(
                'Новый' => 'new',
                'Подтвержден' => 'confirm',
                'В доставке' => 'deliver',
                'Выполнен' => 'complete',
                'Отменен' => 'cancel'
            )));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('purchase_person', null, array('label' => 'ФИО'))
            ->add('purchase_email', null, array('label' => 'Email'))
            ->add('purchase_status', 'doctrine_orm_choice', array('label' => 'Статус'), 'choice', array('choices' => array(
                'Новый' => 'new',
                'Подтвержден' => 'confirm',
                'В доставке' => 'deliver',
                'Выполнен' => 'complete',
                'Отменен' => 'cancel'
            )));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('purchase_id', null, array('label' => 'ID'))
            ->add('purchase_person', null, array('label' => 'ФИО'))
            ->add('purchase_email', null, array('label' => 'Email'))
            ->add('purchase_date', null, array('label' => 'Дата'))
            ->add('purchase_sum', null, array('label' => 'Сумма', 'editable' => true))
            ->add('purchase_status', 'choice', array('label' => 'Статус', 'choices' => array(
                'new' => 'Новый',
                'confirm' => 'Подтвержден',
                'deliver' => 'В доставке',
                'complete' => 'Выполнен',
                'cancel' => 'Отменен'
            ), 'editable' => true))
            ->add('_action', 'actions', array(
                'label' => 'Операции',
                'actions' => array(
                    'edit' => array(),
                    'product_item' => array('template' => 'AppBundle::Admin/purchase_item.html.twig'),
                )));
    }
    
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create')->remove('delete');
    }

    public function toString($object)
    {
        return $object instanceof \AppBundle\Entity\Purchase
            ? $object->getPurchaseId()
            : 'Новый заказ';
    }
}