<?php

namespace App\Controller\Admin;

use App\Entity\RefundConfiguration;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class RefundConfigurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RefundConfiguration::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Refund Configuration')
            ->setEntityLabelInPlural('Refund Configurations')
            ->setSearchFields(['id']);
    }

    public function configureFields(string $pageName): iterable
    {
        $dateStart = DateField::new('dateStart');
        $id = IntegerField::new('id', 'ID');
        $nbKmNotRefund = IntegerField::new('nbKmNotRefund', 'Date start');
        $euroPerKm = NumberField::new('euroPerKm', 'Euro per KM');
        $isTollGoRefunded = BooleanField::new('isTollGoRefunded', 'Is toll go refunded');
        $isTollReturnRefunded = BooleanField::new('isTollReturnRefunded', 'Is toll return refunded');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$dateStart];
        } else {
            return [$dateStart, $nbKmNotRefund, $euroPerKm, $isTollGoRefunded, $isTollReturnRefunded];
        }
    }
}
