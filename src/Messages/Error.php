<?php

namespace App\Messages;

class Error
{
    public static function file_not_found(string $path = ''): string
    {
        return 'Error file '.$path.' not found';
    }

    public static function file_failed_to_read(string $path = ''): string
    {
        return 'Error file '.$path.' failed to read';
    }

    public static function json_invalid(): string
    {
        return 'json format invalid';
    }

    public static function array_empty($array = 'array'): string
    {
        return $array.'array is empty';
    }
}
