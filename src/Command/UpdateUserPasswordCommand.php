<?php
    namespace App\Command;

    use App\Entity\User;
    use App\Service\UserManager;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

class UpdateUserPasswordCommand extends Command
    {

        public function __construct(UserManager $userManager, EntityManagerInterface $entityManager)
        {
            $this->userManager = $userManager;
            $this->entityManager = $entityManager;

            parent::__construct();
        }

        protected function configure()
        {
            $this
                // the name of the command (the part after "bin/console")
                ->setName('app:update-pwd-user')

                // the short description shown while running "php bin/console list"
                ->setDescription('Update password for one user')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to update the password of one user...')
                ->addArgument('username', InputArgument::REQUIRED, 'User login')
                ->addArgument('password', InputArgument::REQUIRED, 'User password')
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $username = $input->getArgument('username');

            $user = $this->entityManager->getRepository(User::class)->findOneByUsername($username);
            if ($user) {
                $this->userManager->updatePassword($user, $input->getArgument('password'));
            }
        }
    }
