<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\UploadController;
use App\Services\Implementation\CsvService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use Illuminate\Http\UploadedFile;

class UploadControllerTest extends TestCase {

    use RefreshDatabase;

    protected $csvService;

    protected function setUp(): void {
        parent::setUp();

        $this->setDatabaseConfig();

        $this->csvService = $this->createMock(CsvService::class);
    }

    protected function setDatabaseConfig() {
        putenv('DB_CONNECTION=mysql');
        putenv('DB_HOST=' . env('DB_TEST_HOST'));
        putenv('DB_PORT=' . env('DB_TEST_PORT'));
        putenv('DB_DATABASE=' . env('DB_TEST_DATABASE'));
        putenv('DB_USERNAME=' . env('DB_TEST_USERNAME'));
        putenv('DB_PASSWORD=' . env('DB_TEST_PASSWORD')); // Adicione se necessário
    }

    public function testProcessar() {

        $file = UploadedFile::fake()->create('input.csv', 100, 'text/csv');

        $response = $this->json('POST', '/api/upload', [
            'file' =>  $file,
        ]);

        $response->assertStatus(200);
    }
}