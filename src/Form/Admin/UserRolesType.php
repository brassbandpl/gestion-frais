<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRolesType extends AbstractType
{
    public const VALID_ROLES = [
        'Admin' => 'ROLE_ADMIN',
        'Utilisateur' => 'ROLE_USER',
    ];

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['choices' => self::VALID_ROLES]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder->addModelTransformer(new CallbackTransformer(
            function ($rolesAsArray) {
                // transform the array to a string
                return implode(', ', $rolesAsArray);
            },
            function ($rolesAsString) {
                // transform the string back to an array
                return explode(', ', $rolesAsString);
            }
        ));
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
