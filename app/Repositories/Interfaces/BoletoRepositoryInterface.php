<?php

namespace App\Repositories\Interfaces;

use App\Models\Boleto;
use Illuminate\Support\Collection;

interface BoletoRepositoryInterface {

    function salvarBoleto(Array $data): void;
}
