<?php

namespace Tests\Unit\Service;

use App\Services\Implementation\csvProcessorService;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CsvProcessorServiceTest extends TestCase {

    protected $csvProcessorService;

    protected function setUp(): void {
        parent::setUp();

        $this->setDatabaseConfig();

        config(['services.csv.batch_size' => 2]); 

        $this->csvProcessorService = Mockery::mock(CsvProcessorService::class)->makePartial()->makePartial()->shouldAllowMockingProtectedMethods();;

        
    }

    protected function setDatabaseConfig() {
        putenv('DB_CONNECTION=mysql');
        putenv('DB_HOST=' . env('DB_TEST_HOST'));
        putenv('DB_PORT=' . env('DB_TEST_PORT'));
        putenv('DB_DATABASE=' . env('DB_TEST_DATABASE'));
        putenv('DB_USERNAME=' . env('DB_TEST_USERNAME'));
        putenv('DB_PASSWORD=' . env('DB_TEST_PASSWORD')); // Adicione se necessário
    }

    public function testProcess() {

        $csvProcessorService = Mockery::mock(CsvProcessorService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $csvData = [
            ['name' => 'João', 'governmentId' => '123', 'email' => 'joao@exemplo.com', 'debtAmount' => '100.0', 'debtDueDate' => '2024-11-01', 'debtId' => '1'],
            ['name' => 'José', 'governmentId' => '321', 'email' => 'jose@exemplo.com', 'debtAmount' => '200.0', 'debtDueDate' => '2024-11-02', 'debtId' => '2'],
            ['name' => 'Ana', 'governmentId' => '222', 'email' => 'ana@exemplo.com', 'debtAmount' => '300.0', 'debtDueDate' => '2024-11-03', 'debtId' => '3'],
        ];

        $filePath = tempnam(sys_get_temp_dir(), 'test') . '.csv';
        $handle = fopen($filePath, 'w');
        
        fputcsv($handle, array_keys($csvData[0]));
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $csvProcessorService->shouldReceive('isValid')->andReturn(true);

        $csvProcessorService->shouldReceive('transformData')->andReturnUsing(function ($data) {
            return $data;
        });

        $csvProcessorService->shouldReceive('saveData')
            ->withArgs(function ($batchData) use ($csvData) {
                return in_array($batchData[0], $csvData);
            })
            ->twice();

        $csvProcessorService->process($filePath);

        unlink($filePath);
    }
}