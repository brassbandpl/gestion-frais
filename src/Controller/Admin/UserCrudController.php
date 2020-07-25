<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('User')
            ->setSearchFields(['id', 'username', 'email', 'roles']);
    }

    public function configureFields(string $pageName): iterable
    {
        $username = TextField::new('username');
        $email = TextField::new('email');
        $password = TextField::new('password');
        $dateBegin = DateField::new('dateBegin');
        $dateEnd = DateField::new('dateEnd');
        $id = IntegerField::new('id', 'ID');
        $roles = TextField::new('roles');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $username, $email, $dateBegin, $dateEnd];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $username, $email, $password, $dateBegin, $dateEnd, $roles];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$username, $email, $password, $dateBegin, $dateEnd];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$username, $email, $password, $dateBegin, $dateEnd];
        }
    }
}
