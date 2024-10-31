<?php

namespace App\Jobs;

use App\Services\Interfaces\CsvProcessorServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateBoletoSendEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $csvProcessor;

    public function __construct() {
    }


    public function handle(): void {
        /*
        Seria um processo automático e independente, aqui iria gerar o boleto e enviar por e-mail.
        Dessa forma não sobrecarrega o sistema e não corre o risco de enviar boleto para cliente errado.

        - Nosso handle iria chamar a interface do Service GenerateBoletoService
        - Após gerar o boleto iria fazer upload para algum serviço (AWS por exemplo)
        - Teria um campo no banco para salvar a URL do PDF
        - Recebendo upload com sucesso, iria chamar a interface do Service SendEmailService
        - Enviaria o e-mail com anexo.
        */
    }

}
