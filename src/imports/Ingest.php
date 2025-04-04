<?php

namespace App\imports;

use Symfony\Component\HttpFoundation\Exception\JsonException;

class Ingest
{
    public function get(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return ['error' => 'File not found.'];
        }

        $jsonData = file_get_contents($filePath);
        if (false === $jsonData) {
            return ['error' => 'Failed to read the file.'];
        }

        try {
            $data = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return ['error' => 'Invalid JSON format: '.$e->getMessage()];
        }

        return $this->sanitizeData($data);
    }

    private function sanitizeData(array $data): array
    {
        array_walk_recursive($data, function (&$value) {
            if (is_string($value)) {
                $value = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
            }
        });

        return $data;
    }
}
