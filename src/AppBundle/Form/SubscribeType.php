<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
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
            ->add('subscribe_email', EmailType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('subscribe_person', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('subscribe_company', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('subscribe_type', ChoiceType::class, array(
                'choices'  => array_merge(array('' => null), array_flip(self::$types)), 'attr' => array('style' => 'width: 50%')
            ))
            ->add('subscribe_phone', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('subscribe_fax', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('subscribe_url', TextType::class, array('attr' => array('style' => 'width: 50%', 'class' => 'order')))
            ->add('subscribe_captcha', CaptchaType::class, array('required' => true, 'attr' => array('style' => 'display: block; width: 130px; margin-top: 5px;')))
            ->add('send', SubmitType::class, array('label' => 'Подписаться'))
            ->getForm();
    }
}