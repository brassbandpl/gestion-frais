<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;

class ExpenseEventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nbKmGo');
        $formMapper->add('nbKmReturn');
        $formMapper->add('tollGo');
        $formMapper->add('tollReturn');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $dateStart = new \DateTime();
        $dateEnd = new \DateTime();
        $datagridMapper->add('event.date', DateRangeFilter::class, array(
            'field_type' => DateRangePickerType::class,
            'field_options' => array(
                'field_options_start' => array(
                    'format' => 'dd/MM/y',    
                ),
                'field_options_end' => array(
                    'format' => 'dd/MM/y',    
                ),
            ),
        ));
        $datagridMapper->add('user.username');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('event.date', 'date', array(
            'format' => 'd/m/Y'
        ));
        $listMapper->add('user.username');
        $listMapper->add('totalRefund', 'currency', [
            'currency' => '€',
            'locale' => 'fr',
        ]);
        
    }
}