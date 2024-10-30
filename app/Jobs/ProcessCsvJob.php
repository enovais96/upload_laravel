<?php

namespace App\Jobs;

use App\Services\Interfaces\CsvProcessorServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessCsvJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $csvProcessor;

    public function __construct($filePath, CsvProcessorServiceInterface $csvProcessor) {
        $this->filePath = $filePath;
        $this->csvProcessor = $csvProcessor;
    }


    public function handle(): void {
        $this->csvProcessor->process(storage_path('app/' . $this->filePath));

        Storage::delete($this->filePath);
    }

}
