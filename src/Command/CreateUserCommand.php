<?php
    namespace App\Command;

    use App\Service\UserManager;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class CreateUserCommand extends Command
    {
        /** @var UserManager $userManager */
        private $userManager;

        public function __construct(UserManager $userManager)
        {
            $this->userManager = $userManager;

            parent::__construct();
        }

        protected function configure()
        {
            $this
                // the name of the command (the part after "bin/console")
                ->setName('app:create-user')

                // the short description shown while running "php bin/console list"
                ->setDescription('Creates a new user.')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to create a user...')
                ->addArgument('username', InputArgument::REQUIRED, 'User login')
                ->addArgument('password', InputArgument::REQUIRED, 'User password')
                ->addArgument('email', InputArgument::REQUIRED, 'User email')
                ->addArgument('dateBegin', InputArgument::REQUIRED, 'Date begin')
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $this->userManager->create(
                $input->getArgument('username'), 
                $input->getArgument('password'), 
                $input->getArgument('email'),
                $input->getArgument('dateBegin')
            );
        }
    }
