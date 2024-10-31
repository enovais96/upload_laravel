<?php

namespace Tests\Unit\Service;

use App\Services\Implementation\CsvService;
use App\Jobs\ProcessCsvJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

class CsvServiceTest extends TestCase {
    use RefreshDatabase;

    protected $csvService;

    protected function setUp(): void {
        parent::setUp();

        $this->setDatabaseConfig();

        $mockCsvProcessorService = Mockery::mock(\App\Services\Interfaces\CsvProcessorServiceInterface::class);

        $this->csvService = new CsvService($mockCsvProcessorService);
        
    }

    protected function setDatabaseConfig() {
        putenv('DB_CONNECTION=mysql');
        putenv('DB_HOST=' . env('DB_TEST_HOST'));
        putenv('DB_PORT=' . env('DB_TEST_PORT'));
        putenv('DB_DATABASE=' . env('DB_TEST_DATABASE'));
        putenv('DB_USERNAME=' . env('DB_TEST_USERNAME'));
        putenv('DB_PASSWORD=' . env('DB_TEST_PASSWORD')); // Adicione se necessário
    }

    public function testUploadAndProcess() {

        Storage::fake('local');

        Queue::fake();

        $file = UploadedFile::fake()->create('input.csv', 100, 'text/csv');

        $request = new Request();
        $request->files->set('file', $file);

        $this->csvService->uploadAndProcess($request);

        Storage::disk('local')->assertExists('uploads/' . $file->hashName());
    }
}