<?php

namespace App\Command;

use App\Entity\Users;
use App\imports\Ingest;
use App\Services\UsersServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'imports-users',
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
        $this->usersRepository = $entityManager->getRepository(Users::class);
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $usersservices = new UsersServices($this->entityManager, $this->projectDir);

        $user_json = $this->projectDir.'/var/json/users.json';

        if (!file_exists($user_json)) {
            $io->error('file does not exist');

            return Command::FAILURE;
        }

        $read_json = new Ingest();
        $users = [];

        try {
            $users = $read_json->getJson($user_json);

            $save = $usersservices->saveUsers($users);

            $io->info(count($users).' users getting');

            if ($save) {
                $io->info($this->usersRepository->count([]).' users put into database');
            }
        } catch (\Exception $e) {
            $io->error('Erreur lors de la lecture du fichier : '.$e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
