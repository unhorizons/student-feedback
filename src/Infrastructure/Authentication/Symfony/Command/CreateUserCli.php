<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Command;

use Application\Authentication\Command\CreateUserCommand;
use Domain\Authentication\ValueObject\Roles;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Class CreateUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsCommand(
    name: 'devscast:authentication:create-user',
    description: 'Creates users and stores them in the database',
)]
final class CreateUserCli extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates users and stores them in the database')
            ->setHelp($this->getCommandHelp())
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the new user')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'If set, the user is created as an administrator');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (
            null !== $input->getArgument('email')
        ) {
            return;
        }

        $this->io->title('Add User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console devscast:authentication:create-user name email@example.com password ',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        // Ask for the email if it's not defined
        $email = $this->io->ask('Email');
        $input->setArgument('email', $email);
    }

    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('create-user-command');

        $email = strval($input->getArgument('email'));
        $isAdmin = boolval($input->getOption('admin'));

        $this->bus->dispatch(new CreateUserCommand($email, $isAdmin ? Roles::admin() : Roles::student()));

        $this->io->success(sprintf('%s was successfully created: (%s)', $isAdmin ? 'Administrator user' : 'User', $email));
        $event = $stopwatch->stop('create-user-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf(
                'New user database email: %s / Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                $email,
                $event->getDuration(),
                $event->getMemory() / (1024 ** 2)
            ));
        }

        return Command::SUCCESS;
    }

    /**
     * The command help is usually included in the configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> command creates new users and saves them in the database:
  <info>php %command.full_name%</info> <comment>username password email</comment>
By default the command creates regular users. To create administrator users,
add the <comment>--admin</comment> option:
  <info>php %command.full_name%</info> username password email <comment>--admin</comment>
If you omit any of the three required arguments, the command will ask you to
provide the missing values:
  # command will ask you for the email
  <info>php %command.full_name%</info> <comment>username password</comment>
  # command will ask you for the email and password
  <info>php %command.full_name%</info> <comment>username</comment>
  # command will ask you for all arguments
  <info>php %command.full_name%</info>
HELP;
    }
}
