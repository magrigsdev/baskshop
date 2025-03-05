<?php

namespace App\Tests;

use App\Entity\Users;
use App\Services\UsersServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UsersServicesTest extends KernelTestCase
{
    private $entityManager;
    private $usersRepository;
    private $projectDir;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->usersRepository = $this->entityManager->getRepository(Users::class);
        $this->projectDir = $container->getParameter('kernel.project_dir');
    }

    public function testGetusers(): void
    {
        $json = $this->projectDir.'/public/files_json/users_data.json';
        $usersservices = new UsersServices($this->entityManager, $this->projectDir);
        $users = $usersservices->getUsersFromFile($json);
        // dump($users);
        $this->assertNotEmpty($users, 'array of users');
    }

    // public function testImportThemeSave(): void
    // {
    //     $ExtractServices = new ExtractService($this->entityManager, $this->projectDir);
    //     $excel_file = $this->projectDir.'/public/File/emissions_GES_structure.xlsx';
    //     $themes = $ExtractServices->GetThemesFromExcelFile($excel_file);
    //     $preparedThemes = $ExtractServices->PrepareThemesForDatabase($themes);
    //     $saveThemes = $ExtractServices->SaveThemesOnDatabase($preparedThemes);

    //     $this->assertTrue($saveThemes, 'themes are saved');
    //     $this->assertTrue($this->themeRepository->isFirstThemeParentIdNull(), 'first theme has ParentId : null');
    //     $this->assertTrue($this->themeRepository->isAllThemesParentIdAreNotNull////(), 'The parentId for all themes is not null, except for the first theme.');
    // }
}
