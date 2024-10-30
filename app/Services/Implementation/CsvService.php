<?php

namespace App\Services\Implementation;

use Illuminate\Http\Request;
use App\Jobs\ProcessCsvJob;
use App\Services\Interfaces\CsvServiceInterface;
use App\Services\Interfaces\CsvProcessorServiceInterface;

class CsvService  implements CsvServiceInterface {
    
    protected $csvProcessorServiceInterface;

    public function __construct(CsvProcessorServiceInterface $csvProcessorServiceInterface) {
        $this->csvProcessorServiceInterface = $csvProcessorServiceInterface;
    }

    public function uploadAndProcess(Request $request) {
        $path = $request->file('file')->store('uploads');
        
        ProcessCsvJob::dispatch($path, $this->csvProcessorServiceInterface);
    }
}