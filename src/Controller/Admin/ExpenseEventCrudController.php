<?php

namespace App\Controller\Admin;

use App\Entity\ExpenseEvent;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class ExpenseEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpenseEvent::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('ExpenseEvent')
            ->setEntityLabelInPlural('ExpenseEvent')
            ->setSearchFields(['id', 'nbKmGo', 'nbKmReturn', 'tollGo', 'tollReturn', 'refundKmGo', 'refundKmReturn', 'refundTollGo', 'refundTollReturn']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('event'))
            ->add(EntityFilter::new('user'));
    }

    public function configureFields(string $pageName): iterable
    {
        $nbKmGo = IntegerField::new('nbKmGo');
        $nbKmReturn = IntegerField::new('nbKmReturn');
        $tollGo = NumberField::new('tollGo');
        $tollReturn = NumberField::new('tollReturn');
        $refundKmGo = NumberField::new('refundKmGo');
        $refundKmReturn = NumberField::new('refundKmReturn');
        $refundTollGo = NumberField::new('refundTollGo');
        $refundTollReturn = NumberField::new('refundTollReturn');
        $event = AssociationField::new('event');
        $user = AssociationField::new('user');
        $id = IntegerField::new('id', 'ID');
        $userUsername = TextareaField::new('user.username');
        $eventDate = DateField::new('event.date');
        $paied = BooleanField::new('paied');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $userUsername, $eventDate];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $nbKmGo, $nbKmReturn, $tollGo, $tollReturn, $refundKmGo, $refundKmReturn, $refundTollGo, $refundTollReturn, $paied, $event, $user];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nbKmGo, $nbKmReturn, $tollGo, $tollReturn, $refundKmGo, $refundKmReturn, $refundTollGo, $refundTollReturn, $event, $user];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nbKmGo, $nbKmReturn, $tollGo, $tollReturn, $refundKmGo, $refundKmReturn, $refundTollGo, $refundTollReturn, $paied, $event, $user];
        }
    }
}
