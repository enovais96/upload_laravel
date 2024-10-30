<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Implementation\CsvService;

class UploadController extends Controller {
    
    protected $csvService;

    public function __construct(CsvService $csvService) {
        $this->csvService = $csvService;
    }

    public function processar(Request $request) {
        $this->csvService->uploadAndProcess($request);

        return response()->json(['message' => 'Arquivo carregado com sucesso! O processamento será realizado em segundo plano.'], 200);
    }
}