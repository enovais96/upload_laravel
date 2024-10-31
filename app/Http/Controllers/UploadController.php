<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Implementation\CsvService;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller {
    
    protected $csvService;

    public function __construct(CsvService $csvService) {
        $this->csvService = $csvService;
    }

    public function processar(Request $request) {
        $validator = Validator::make($request->all(), $this->regrasImportacao(), $this->mensagensPersonalizadas());
        
        if ($validator->fails()) {
            return new JsonResponse($validator->messages(), 400);
        }

        $this->csvService->uploadAndProcess($request);

        return response()->json(['message' => 'Arquivo carregado com sucesso! O processamento será realizado em segundo plano.'], 200);
    }

    private function regrasImportacao(): array{
        return [
            'file' => 'required|file|mimes:csv' // Adicione outros tipos de arquivo se necessário
        ];
    }

    private function mensagensPersonalizadas(): array {
        return [
            'file.required' => 'Um arquivo é necessário para o upload.',
            'file.file' => 'O arquivo enviado não é válido.',
            'file.mimes' => 'O arquivo deve ser do tipo CSV.'
        ];
    }
}