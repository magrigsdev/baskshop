<?php

namespace App\imports;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class Ingest
{
    public function getJson($filePath): array
    {
        if (!file_exists($filePath)) {
            return ['error' => 'File not found.'];
        }
    
        $jsonData = file_get_contents($filePath);
        if ($jsonData === false) {
            return ['error' => 'Failed to read the file.'];
        }
    
        try {
            $data = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return ['error' => 'Invalid JSON format: ' . $e->getMessage()];
        }
    
        return $data;
    }
}
