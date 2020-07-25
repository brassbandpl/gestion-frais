<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Event')
            ->setEntityLabelInPlural('Event')
            ->setSearchFields(['id', 'type', 'addressLabel', 'address', 'postalCode', 'city']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('period'));
    }

    public function configureFields(string $pageName): iterable
    {
        $date = DateField::new('date');
        $type = TextField::new('type');
        $addressLabel = TextField::new('addressLabel');
        $address = TextField::new('address');
        $postalCode = TextField::new('postalCode');
        $city = TextField::new('city');
        $closed = Field::new('closed');
        $period = AssociationField::new('period');
        $id = IntegerField::new('id', 'ID');
        $expenseEvents = AssociationField::new('expenseEvents');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$date, $type, $addressLabel, $closed, $period];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $date, $type, $addressLabel, $address, $postalCode, $city, $closed, $expenseEvents, $period];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$date, $type, $addressLabel, $address, $postalCode, $city, $closed, $period];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$date, $type, $addressLabel, $address, $postalCode, $city, $closed, $period];
        }
    }
}
