<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationStructure;

class OrganizationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear old manual data
        \Schema::disableForeignKeyConstraints();
        OrganizationStructure::truncate();
        \Schema::enableForeignKeyConstraints();

        // Level 1: Menteri
        $menteri = OrganizationStructure::create([
            'position_name' => 'MENTERI KEHUTANAN',
            'echelon' => 'Pimpinan',
            'sort_order' => 1
        ]);

        // Level 2: Wakil Menteri
        $wamen = OrganizationStructure::create([
            'position_name' => 'WAKIL MENTERI KEHUTANAN',
            'echelon' => 'Pimpinan',
            'parent_id' => $menteri->id,
            'sort_order' => 1
        ]);

        $filePath = base_path('satker_data.json');
        if (!file_exists($filePath)) {
            $this->command->error('File satker_data.json tidak ditemukan.');
            return;
        }

        $data = json_decode(file_get_contents($filePath), true);
        
        $eselon1Map = [];

        $this->command->info('Memproses impor data SATKER...');
        
        foreach ($data as $rowIndex => $row) {
            // Skip the header
            if ($rowIndex == 1 || empty($row['A']) || $row['A'] == 'Eselon I ') {
                continue;
            }

            $eselon1Name = trim($row['A']);
            $unitName = !empty($row['C']) ? trim($row['C']) : null;
            $lokasi = !empty($row['B']) ? trim($row['B']) : null; // PUSAT/UPT

            // Ensure Eselon I exists under WAMEN
            if (!isset($eselon1Map[$eselon1Name])) {
                $eselon1 = OrganizationStructure::create([
                    'position_name' => $eselon1Name,
                    'echelon' => 'Eselon I',
                    'parent_id' => $wamen->id,
                    'sort_order' => count($eselon1Map) + 1
                ]);
                $eselon1Map[$eselon1Name] = $eselon1->id;
            }

            // Insert child Unit Kerja
            if ($unitName) {
                // Tentukan perkiraan echelon berdasarkan prefix
                $echelonLevel = null;
                if (str_starts_with(strtolower($unitName), 'direktorat') || str_starts_with(strtolower($unitName), 'pusat') || str_starts_with(strtolower($unitName), 'biro') || str_starts_with(strtolower($unitName), 'inspektorat wilayah') || str_starts_with(strtolower($unitName), 'sekretariat')) {
                    $echelonLevel = 'Eselon II';
                } elseif (str_starts_with(strtolower($unitName), 'balai besar')) {
                    $echelonLevel = 'Eselon II'; // commonly balai besar is eselon ii
                } elseif (str_starts_with(strtolower($unitName), 'balai')) {
                    $echelonLevel = 'Eselon III'; // balai is typically eselon iii
                } elseif (str_starts_with(strtolower($unitName), 'staf ahli')) {
                    $echelonLevel = 'Staf Ahli';
                }

                OrganizationStructure::firstOrCreate([
                    'position_name' => $unitName,
                    'parent_id' => $eselon1Map[$eselon1Name]
                ], [
                    'echelon' => $echelonLevel,
                    'sort_order' => 1 // simplified sort order for mass import
                ]);
            }
        }
        
        $this->command->info('Data Struktur Organisasi SATKER berhasil diimpor!');
    }
}
