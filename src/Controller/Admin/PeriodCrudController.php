<?php

namespace App\Controller\Admin;

use App\Entity\Period;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class PeriodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Period::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Period')
            ->setEntityLabelInPlural('Period')
            ->setSearchFields(['id']);
    }

    public function configureFields(string $pageName): iterable
    {
        $dateStart = DateField::new('dateStart');
        $dateEnd = DateField::new('dateEnd');
        $events = AssociationField::new('events');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $dateStart, $dateEnd, $events];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $dateStart, $dateEnd, $events];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$dateStart, $dateEnd, $events];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$dateStart, $dateEnd, $events];
        }
    }
}
