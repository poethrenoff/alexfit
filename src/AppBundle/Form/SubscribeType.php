<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\Subscribe;

class SubscribeType extends AbstractType
{
    public static $types = array(
        'wholesale' => 'оптовая',
        'retail' => 'розничная',
    );
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Subscribe::class,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('name', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('company', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('type', ChoiceType::class, array(
                'choices'  => array_merge(array('' => null), array_flip(self::$types)), 'attr' => array('style' => 'width: 50%')
            ))
            ->add('phone', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('fax', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('url', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('send', SubmitType::class, array('label' => 'Подписаться'))
            ->getForm();
    }
}