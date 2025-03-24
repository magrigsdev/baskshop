<?php

namespace App\imports;

class Ingest
{
    public function getJson($filePath): array
    {
        if (!file_exists($filePath)) {
            return ['error' => 'File not found.'];
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return ['error' => 'Invalid JSON format.'];
        }

        return $data;
    }
}
