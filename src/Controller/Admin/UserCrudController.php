<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\UserRolesType;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    /** @var UserManager $userManager */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
        
    }
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
        $dateBegin = DateField::new('dateBegin');
        $dateEnd = DateField::new('dateEnd');
        $id = IntegerField::new('id', 'ID');
        $roles = ChoiceField::new('roles');
        $roles->setFormType(UserRolesType::class);
        $roles->setChoices(UserRolesType::VALID_ROLES);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $username, $email, $dateBegin, $dateEnd];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $username, $email, $dateBegin, $dateEnd, $roles];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$username, $email, $dateBegin];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$username, $email, $dateBegin, $dateEnd, $roles];
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $password = random_bytes(18);
        $this->userManager->create($entityInstance->getUsername(), $password, $entityInstance->getEmail(), $entityInstance->getDateBegin()->format('Y-m-d'));
    }
}
