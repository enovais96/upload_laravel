<?php

namespace App\Services\Interfaces;

interface CsvProcessorServiceInterface {
    
    public function process($filePath): void;
    
}