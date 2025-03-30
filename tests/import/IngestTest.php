<?php

namespace App\Tests\Import;

use App\imports\Ingest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IngestTest extends KernelTestCase
{
    private $project_dir;

    public function testIngest(): void
    {
        self::bootKernel();
        $this->project_dir = static::getContainer()->getParameter('kernel.project_dir');

        $json_file = $this->project_dir.'/var/test/ingestTest.json';
        $ingest = new Ingest();
        $result = $ingest->get($json_file);

        $this->assertIsArray($result, 'The result should be an array.');
    }
}
