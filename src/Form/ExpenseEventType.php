<?php

namespace App\Form;

use App\Entity\ExpenseEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\NumberToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbKmGo', IntegerType::class, ['required' => false,])
            ->add('nbKmReturn', IntegerType::class, ['required' => false,])
            ->add('tollGo', NumberType::class, [
                'required' => false, 
                'scale' => 2, 
                'html5' => true, 
                'rounding_mode' => NumberToLocalizedStringTransformer::ROUND_HALF_EVEN,
                'attr' => ['step' => 'any']
            ])
            ->add('tollReturn', NumberType::class, [
                'required' => false, 
                'scale' => 2, 
                'html5' => true, 
                'rounding_mode' => NumberToLocalizedStringTransformer::ROUND_HALF_EVEN,
                'attr' => ['step' => 'any']
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpenseEvent::class,
        ]);
    }
}
