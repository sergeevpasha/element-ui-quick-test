<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCsvProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import property data from a CSV file into the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $this->info("Importing data from: $filePath");

        $rowCount = 0;

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');

            $expectedColumns = ['Name', 'Price', 'Bedrooms', 'Bathrooms', 'Storeys', 'Garages'];
            if ($header !== $expectedColumns) {
                $this->error("Invalid CSV format. Expected columns: " . implode(', ', $expectedColumns));
                fclose($handle);
                return;
            }

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data = [
                    'name' => $row[0],
                    'price' => (int) $row[1] * 100,
                    'bedrooms' => (int) $row[2],
                    'bathrooms' => (int) $row[3],
                    'storeys' => (int) $row[4],
                    'garages' => (int) $row[5]
                ];

                DB::table('properties')->insert($data);
                $rowCount++;
            }
            fclose($handle);

            $this->info("Successfully imported $rowCount rows into the 'properties' table.");
        } else {
            $this->error("Failed to open the file.");
        }
    }
}
