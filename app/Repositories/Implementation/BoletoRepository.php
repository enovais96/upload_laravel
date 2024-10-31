<?php

namespace App\Repositories\Implementation;

use App\Models\Boleto;
use App\Repositories\Interfaces\BoletoRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BoletoRepository implements BoletoRepositoryInterface {

    public function salvarBoleto(Array $data): void {
        DB::beginTransaction();
        DB::table('boletos')->insertOrIgnore($data);
        DB::commit();
    }

}
