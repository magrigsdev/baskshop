<?php 

namespace App\imports;

 class Ingest 
{
    function getJson($filePath) {
        if (!file_exists($filePath)) {
            return ["error" => "File not found."];
        }
    
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ["error" => "Invalid JSON format."];
        }
    
        return $data;
    }
    
    
}