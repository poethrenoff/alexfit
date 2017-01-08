<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\Purchase;

class PurchaseType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Purchase::class,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('purchase_email', EmailType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('purchase_person', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('purchase_phone', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('purchase_address', TextareaType::class, array('attr' => array('cols' => '100', 'rows' => '5', 'style' => 'width: 400px')))
            ->add('purchase_comment', TextareaType::class, array('attr' => array('cols' => '100', 'rows' => '5', 'style' => 'width: 400px')))
            ->add('send', SubmitType::class, array('label' => 'Отправить'))
            ->getForm();
    }
}