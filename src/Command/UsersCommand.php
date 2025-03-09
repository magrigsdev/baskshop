<?php

namespace App\Command;

use App\Entity\Users;
use App\Services\UsersServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'users-command',
    description: 'get users and import them into the database',
)]
class UsersCommand extends Command
{
    private $project_dir;
    private $entity_manager;
    private $users_Repository;

    public function __construct(string $project_dir, EntityManagerInterface $entity_manager)
    {
        $this->project_dir = $project_dir;
        $this->entity_manager = $entity_manager;
        $this->themeRepository = $entity_manager->getRepository(Users::class);
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->addArgument('putusers', InputArgument::OPTIONAL, 'put users into database themes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $putusers = $input->getArgument('putusers');
        $users_services = new UsersServices($this->entity_manager, $this->project_dir);

        if ($putusers) {
            $json = $this->project_dir.'/var/json/users.json';

            if (!file_exists($json)) {
                $io->error('file does not exist');

                return Command::FAILURE;
            }
            try {
                $users = $users_services->getUsersFromFile($json);
                $put = $users_services->putUsersIntoDatabase($users);

                $io->info(count($users).' users getting');

                if ($put) {
                    $io->info($this->users_Repository->count([]).' users put into database');
                }
            } catch (\Exception $e) {
                $io->error('Erreur lors de la lecture du fichier : '.$e->getMessage());

                return Command::FAILURE;
            }

            return Command::SUCCESS;
        }

        return Command::SUCCESS;
    }
}
