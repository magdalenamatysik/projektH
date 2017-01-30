<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016-10-22
 * Time: 07:10
 */

namespace AppBundle\Form;


use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\DataCollector\Type\DataCollectorTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class add_job extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('time', DateTimeType::class)
            ->add('duration', NumberType::class)
            ->add('dodaj', SubmitType::class, array('label'=>'dodaj zadanie', 'attr' => array('class'=>'button')) );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\job',
        ));

    }



    public function getName()
    {
        return 'app_bundle_user_type';
    }
}