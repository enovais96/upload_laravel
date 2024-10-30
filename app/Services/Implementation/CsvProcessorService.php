<?php

namespace App\Services\Implementation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\CsvProcessorServiceInterface;

class CsvProcessorService implements CsvProcessorServiceInterface {

    protected $batchSize;

    public function __construct(int $batchSize = 1000) {
        $this->batchSize = $batchSize;
    }

    public function process($filePath): void {

        if (($handle = fopen($filePath, 'r')) !== false) {
            DB::disableQueryLog();

            $batchData = [];
            $header = fgetcsv($handle, 1000, ',');

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data = array_combine($header, $row);

                if ($this->isValid($data)) {
                    $batchData[] = $this->transformData($data);
                }

                if (count($batchData) >= $this->batchSize) {
                    $this->saveData($batchData);
                    $batchData = [];
                }
            }

            if (!empty($batchData)) {
                $this->saveData($batchData);
            }

            fclose($handle);

            DB::enableQueryLog();
        }
    }

    protected function isValid($data): bool {
        return isset($data['name'], $data['governmentId'], $data['email'], $data['debtAmount'], $data['debtDueDate'], $data['debtId']);
    }

    protected function transformData($data): array {
        return [
            'name' => $data['name'],
            'government_id' => $data['governmentId'],
            'email' => $data['email'],
            'debt_amount' => (float)$data['debtAmount'],
            'debt_due_date' => $data['debtDueDate'],
            'debt_id' => $data['debtId'],
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    protected function saveData(array $batchData): void {
        DB::beginTransaction();
        DB::table('boletos')->insertOrIgnore($batchData);
        DB::commit();
    }
}