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
    name: 'userscommand',
    description: 'get users and import them into the database',
)]
class UsersCommand extends Command
{
    private $projectDir;
    private $entityManager;
    private $usersRepository;

    public function __construct(string $projectDir, EntityManagerInterface $entityManager)
    {
        $this->projectDir = $projectDir;
        $this->entityManager = $entityManager;
        $this->themeRepository = $entityManager->getRepository(Users::class);
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
        $usersservices = new UsersServices($this->entityManager, $this->projectDir);

        if ($putusers) {
            $json = $this->projectDir.'/public/files_json/users_data.json';

            if (!file_exists($json)) {
                $io->error('file does not exist');

                return Command::FAILURE;
            }
            try {
                $users = $usersservices->getUsersFromFile($json);
                $put = $usersservices->putUsersIntoDatabase($users);

                $io->info(count($users).' users getting');

                if ($put) {
                    $io->info($this->usersRepository->count([]).' users put into database');
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
