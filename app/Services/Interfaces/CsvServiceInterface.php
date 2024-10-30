<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CsvServiceInterface {
    
    public function uploadAndProcess(Request $request);
    
}