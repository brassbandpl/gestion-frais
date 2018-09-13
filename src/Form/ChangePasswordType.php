<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'new', 
            RepeatedType::class, 
            array(
                'type' => PasswordType::class, 
                'attr' => ['minlength'=>'10'], 
                'invalid_message' => 'Les deux nouveaux mots de passe sont différents',
                'first_options'  => array(
                    'attr' => array('minlength' => '6', 'pattern' => '[^\s]+')
                ),
                'second_options' => array(
                    'attr' => array('minlength' => '6', 'pattern' => '[^\s]+')
                ),
            )
        );
        $builder->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }
}
