<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmployeeController extends Controller
{
    public function index()
    {
        // Get unique periods with count
        $periods = Employee::select('periode', DB::raw('count(*) as count'))
            ->groupBy('periode')
            ->orderByDesc('created_at')
            ->get();
            
        $employeeCount = Employee::count();
        $statisticsPeriod = Setting::where('key', 'statistics_period')->value('value') ?? 'Belum disetel';
        
        return view('admin.employees.index', compact('employeeCount', 'statisticsPeriod', 'periods'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
            'bulan' => 'required|string',
            'tahun' => 'required|string'
        ]);

        $periode = $request->bulan . ' ' . $request->tahun;

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            if (empty($data) || count($data) <= 1) {
                return redirect()->back()->with('error', 'File Excel kosong atau tidak valid.');
            }

            DB::beginTransaction();

            // Replace data only for this specific period
            Employee::where('periode', $periode)->delete();

            // Update the active statistics period in settings to the newly imported one
            Setting::updateOrCreate(
                ['key' => 'statistics_period'],
                ['value' => $periode]
            );

            $insertData = [];
            
            // Start from row 2 assuming row 1 is header
            foreach ($data as $index => $row) {
                if ($index === 1 || empty($row['C']) || empty($row['D'])) { // Basic check
                    continue;
                }

                $insertData[] = [
                    'periode' => $periode,
                    'umur' => $row['B'] ?? null,
                    'kelompok_umur' => $row['C'] ?? null,
                    'jenis_kelamin' => $row['D'] ?? null,
                    'agama' => $row['E'] ?? null,
                    'status_pegawai' => $row['F'] ?? null, // PNS, CPNS, PPPK
                    'jenis_kantor' => $row['G'] ?? null,
                    'jenis_jabatan' => $row['H'] ?? null, // Fungsional, Struktural
                    'kelompok_fungsional' => $row['I'] ?? null,
                    'jabatan' => $row['J'] ?? null,
                    'nama_jabatan' => $row['K'] ?? null,
                    'jabatan_murni' => $row['L'] ?? null,
                    'unit_kerja_eselon_1' => $row['M'] ?? null,
                    'unit_kerja' => $row['N'] ?? null,
                    'pendidikan' => $row['O'] ?? null,
                    'golongan' => $row['P'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Chunk insert to avoid memory issues
                if (count($insertData) >= 1000) {
                    Employee::insert($insertData);
                    $insertData = [];
                }
            }

            if (count($insertData) > 0) {
                Employee::insert($insertData);
            }

            DB::commit();

            return redirect()->back()->with('success', "Data statistik kepegawaian periode {$periode} berhasil diimpor.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error importing employees: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }
}
