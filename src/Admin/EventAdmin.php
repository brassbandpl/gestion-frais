<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('date', DatePickerType::class, array('format'=>'dd/MM/yyyy'));
        $formMapper->add('type', ChoiceType::class, array(
            'choices' => array(
                'Répétition' => 'repetition',
                'Concert' => 'concert',
            ),
        ));
        $formMapper->add('addressLabel');
        $formMapper->add('address');
        $formMapper->add('postalCode');
        $formMapper->add('city');
        $formMapper->add('closed');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('date');
        $datagridMapper->add('type');
        $datagridMapper->add('closed');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('date', 'date', array(
            'format' => 'd/m/Y'
        ));
    }
}