<?php

namespace AkjnBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('displayName', 'text', array(
            'required' => false,
            'mapped' => false,
            'attr' => array('class' => 'vd_name_required')));
//        $builder->add('dob', 'date', array('required' => false, 'widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'attr' => array('class' => 'vd_date_required', 'maxlength' => 10)));
        $builder->add('email', 'email', array(
            'attr' => array('class' => 'vd_email_required'), 
            'required' => false,
            'mapped' => false));
        $builder->add('mobileNumber', 'text', array(
            'required' => false, 
            'mapped' => false,
            'attr' => array('class' => 'vd_mobile_required', 'maxlength' => 10)));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
//            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options' => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
            'mapped' => false,
        ));
        $builder->add('password', 'password', array('required' => false, 'attr' => array('class' => 'vd_name_required')));
        $builder->add('checkpassword', 'password', array('mapped' => false, 'required' => false));
        


        $builder->add('reset', 'reset', array('attr' => array('class' => 'ui-button')));
        $builder->add('submit', 'submit', array('label' => 'Register', 'attr' => array('class' => 'ui-button')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AkjnBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'AkjnReg';
    }

}
