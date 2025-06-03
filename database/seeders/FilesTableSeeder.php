<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilesTableSeeder extends Seeder
{
    public function run(): void
    {
        $fileTypes = ['jpg', 'png', 'pdf', 'txt'];
        $filePaths = [
            'documents/report', 'images/photo', 'scans/scan',
            'files/doc', 'downloads/file', 'uploads/item'
        ];

        $records = [];

        for ($i = 1; $i <= 10; $i++) {
            $type = $fileTypes[array_rand($fileTypes)];
            $path = $filePaths[array_rand($filePaths)] . "_$i." . $type;

            $records[] = [
                'file_path' => $path,
                'file_type' => $type,
                'size' => random_int(100_000, 1_000_000),
                'date_created' => now()->subDays(rand(0, 30))->toDateString(),
                'hash' => Str::random(32),
                'employee_id' => rand(1, 5)
            ];
        }

        DB::table('files')->insert($records);
    }
}
