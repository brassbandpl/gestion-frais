<?php
    namespace App\Command;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class CloseEventCommand extends Command
    {
        /** @var EntityManagerInterface $em */
        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
            parent::__construct();
        }

        protected function configure()
        {
            $this
                // the name of the command (the part after "bin/console")
                ->setName('app:event:close')

                // the short description shown while running "php bin/console list"
                ->setDescription('Close events which are opens since X days.')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to close events...')
                ->addArgument('nbDays', InputArgument::REQUIRED, 'Opens since (in days)')
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $nbDays = $input->getArgument('nbDays');

            $today = new \DateTime('today midnight');
            $dateLimite = $today->sub(new \DateInterval('P'.$nbDays.'D'));

            $events = $this->em->getRepository(Event::class)->findByNotClosedAndDateLessThan($dateLimite);

            /** @var Event $event */
            foreach ($events as $event) {
                $event->setClosed(true);
            }

            $this->em->flush();
        }
    }
