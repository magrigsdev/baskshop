<?php

namespace App\Command;

use App\Entity\Baskets;
use App\Services\BasketsServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'baskets-command',
    description: 'get basket and import them into the database',
)]
class BasketCommand extends Command
{
    private $project_dir;
    private $entity_manager;
    private $basket_repository;

    public function __construct(string $project_dir, EntityManagerInterface $entity_manager)
    {
        $this->project_dir = $project_dir;
        $this->entity_manager = $entity_manager;
        $this->basket_repository = $entity_manager->getRepository(Baskets::class);
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->addArgument('putbaskets', InputArgument::OPTIONAL, 'put baskets into database baskets');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $putbaskets = $input->getArgument('putbaskets');
        $baskets_service = new BasketsServices($this->entity_manager, $this->project_dir);

        if ($putbaskets) {
            $json = $this->project_dir.'/var/json/baskets.json';

            if (!file_exists($json)) {
                $io->error('file does not exist');

                return Command::FAILURE;
            }
            try {
                $baskets = $baskets_service->getBasketsFromFile($json);
                $put = $baskets_service->putBasketsIntoDatabase($baskets);

                $io->info(count($baskets).' baskets getting');

                if ($put) {
                    $io->info($this->basket_repository->count([]).' baskets put into database');
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
