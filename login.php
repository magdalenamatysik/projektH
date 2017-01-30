<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016-10-22
 * Time: 07:10
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class login extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('login', TextType::class)
            ->add('password', PasswordType::class)
            ->add('register', SubmitType::class, array('label'=>'loguj', 'attr' => array('class'=>'button')) ) ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\user',
        ));

    }



    public function getName()
    {
        return 'app_bundle_user_type';
    }
}