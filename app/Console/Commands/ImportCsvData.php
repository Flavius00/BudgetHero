<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;
use App\Models\CsvSave;
use Illuminate\Support\Facades\DB;

class ImportCsvData extends Command
{
    protected $signature = 'import:csv';
    protected $description = 'Import merchants and transactions from CSV files';

    public function handle()
    {
        DB::transaction(function () {
            // ======= Import Merchants =======
            $merchantPath = storage_path('app/merchants.csv');

            if (!file_exists($merchantPath)) {
                $this->error("Merchant CSV not found at $merchantPath");
                return;
            }

            $merchantLines = file($merchantPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $merchantRows = array_map('str_getcsv', $merchantLines);
            array_shift($merchantRows); // Remove header

            foreach ($merchantRows as $row) {
                if (count($row) < 2) continue;

                Store::updateOrCreate(
                    ['name' => trim($row[0])],
                    ['category' => trim($row[1])]
                );
            }

            $this->info('✅ Merchants imported: ' . count($merchantRows));


            // ======= Import Transactions =======
            $transactionsPath = storage_path('app/transactions.csv');

            if (!file_exists($transactionsPath)) {
                $this->error("Transactions CSV not found at $transactionsPath");
                return;
            }

            $transactionLines = file($transactionsPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $transactionRows = array_map('str_getcsv', $transactionLines);
            array_shift($transactionRows); // Remove header

            $imported = 0;
            foreach ($transactionRows as $row) {
                if (count($row) < 4) {
                    $this->warn("⚠️ Skipping row with insufficient data: " . json_encode($row));
                    continue;
                }

                $store = Store::where('name', trim($row[1]))->first();
                if (!$store) {
                    $this->warn("⚠️ Store not found for: " . trim($row[1]));
                    continue;
                }

                $data = [
                    'user_id' => 1, // Adjust this if needed
                    'transaction_date' => $row[0],
                    'store_id' => $store->id,
                    'amount' => $row[2],
                    'is_income' => strtolower(trim($row[3])) === 'income',
                ];

                $this->info("Saving transaction: " . json_encode($data));
                $transaction = CsvSave::create($data);
                $this->info("✅ Saved transaction ID: " . $transaction->id);
                $imported++;
            }

            $this->info("✅ Transactions imported: $imported");
        });

    }
}
