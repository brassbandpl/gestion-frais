<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('dateBegin', DatePickerType::class, array('format'=>'dd/MM/yyyy'));
        $formMapper->add('dateEnd', DatePickerType::class, array('format'=>'dd/MM/yyyy'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username');
        $datagridMapper->add('dateBegin');
        $datagridMapper->add('dateEnd');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('username', 'text');
        $listMapper->add('dateBegin', 'date', array(
            'format' => 'd/m/Y'
        ));
        $listMapper->add('dateEnd', 'date', array(
            'format' => 'd/m/Y'
        ));
    }
}