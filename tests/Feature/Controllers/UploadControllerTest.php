<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class UploadControllerTest extends TestCase {
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        $this->setDatabaseConfig();
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
        Queue::fake();

        $file = UploadedFile::fake()->create('input.csv', 100, 'text/csv');

        $response = $this->json('POST', '/api/upload', [
            'file' =>  $file,
        ]);

        $response->assertStatus(200);

        Storage::disk('local')->assertExists('uploads/' . $file->hashName());
    }
}