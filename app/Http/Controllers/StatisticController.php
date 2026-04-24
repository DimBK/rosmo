<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        ini_set('memory_limit', '512M'); // Ensure memory for collection processing

        $availablePeriods = Employee::select('periode')->distinct()->pluck('periode')->toArray();
        $activeSettingsPeriod = Setting::where('key', 'statistics_period')->value('value');
        $statisticsPeriod = $request->query('periode') ?: ($activeSettingsPeriod ?? 'Tahun Ini');

        $baseQuery = Employee::when($statisticsPeriod !== 'Tahun Ini' && in_array($statisticsPeriod, $availablePeriods), function ($q) use ($statisticsPeriod) {
            return $q->where('periode', $statisticsPeriod);
        });

        // 1. Fetch only required columns to save memory
        $employees = $baseQuery->select(
            'status_pegawai', 'jenis_kelamin', 'jenis_kantor', 'jenis_jabatan', 
            'golongan', 'pendidikan', 'umur', 'unit_kerja_eselon_1', 
            'kelompok_fungsional', 'jabatan', 'unit_kerja', 'nama_jabatan', 'jabatan_murni'
        )->get();

        // Fix string PPPK Paruh Waktu
        $types = ['PNS', 'CPNS', 'PPPK', 'PPPK Paruh Waktu'];

        // Summary Cards
        $totalAsn = $employees->count();
        $totalPns = $employees->where('status_pegawai', 'PNS')->count();
        $totalCpns = $employees->where('status_pegawai', 'CPNS')->count();
        $totalPppk = $employees->where('status_pegawai', 'PPPK')->count();
        $totalPppkParuhWaktu = $employees->where('status_pegawai', 'PPPK Paruh Waktu')->count();

        // 1. Jenis Kelamin (Pie)
        $dataJenisKelamin = $employees->countBy('jenis_kelamin');

        // 2. Lokasi Kerja (Pie)
        $dataLokasiKerja = $employees->countBy('jenis_kantor');

        // 3. Jenis Pegawai per Jenis Kelamin (Bar/Line)
        $dataPegawaiGender = [];
        foreach ($types as $type) {
            $filtered = $employees->where('status_pegawai', $type);
            $dataPegawaiGender[$type] = [
                'Laki-laki' => $filtered->where('jenis_kelamin', 'Laki-laki')->count(),
                'Perempuan' => $filtered->where('jenis_kelamin', 'Perempuan')->count(),
                'Total' => $filtered->count()
            ];
        }

        // 4. Data Berdasarkan Lokasi Kerja per Jenis kelamin (Bar/Line)
        $uniqueKantor = $employees->pluck('jenis_kantor')->filter(fn($val) => !empty(trim($val)))->unique()->values();
        $dataLokasiGender = [];
        foreach ($uniqueKantor as $kan) {
            $catEmps = $employees->where('jenis_kantor', $kan);
            $dataLokasiGender[$kan] = [
                'Laki-laki' => $catEmps->where('jenis_kelamin', 'Laki-laki')->count(),
                'Perempuan' => $catEmps->where('jenis_kelamin', 'Perempuan')->count(),
                'Total' => $catEmps->count()
            ];
        }
        uasort($dataLokasiGender, fn($a, $b) => $b['Total'] <=> $a['Total']);

        $categorizeJabatan = function ($jenisJabatan) {
            if (!$jenisJabatan) return 'Tidak Diketahui';
            if (str_contains(strtolower($jenisJabatan), 'fungsional')) return 'Fungsional';
            if (str_contains(strtolower($jenisJabatan), 'pelaksana')) return 'Pelaksana';
            if (str_contains(strtolower($jenisJabatan), 'paruh waktu')) return 'Pelaksana';
            return 'Struktural';
        };

        // 5. Data ASN per ASN Table
        $jabatanCategories = ['Struktural', 'Fungsional', 'Pelaksana'];
        $tableAsnPerAsn = [];
        foreach ($jabatanCategories as $cat) {
            $tableAsnPerAsn[$cat] = [
                'Laki-laki' => $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === $cat)->where('jenis_kelamin', 'Laki-laki')->count(),
                'Perempuan' => $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === $cat)->where('jenis_kelamin', 'Perempuan')->count()
            ];
        }

        // 6. Pangkat/Golongan PNS + CPNS (Chart uses all, Table rolled up to I, II, III, IV)
        $pnsEmployees = $employees->whereIn('status_pegawai', ['PNS', 'CPNS']);
        $dataGolonganPns = []; 
        $uniqueGolPns = $pnsEmployees->pluck('golongan')->filter(fn($val) => !empty(trim($val)))->unique()->sort()->values();
        foreach ($uniqueGolPns as $gol) {
            $filtered = $pnsEmployees->where('golongan', $gol);
            $dataGolonganPns[$gol] = [
                'Laki-laki' => $filtered->where('jenis_kelamin', 'Laki-laki')->count(),
                'Perempuan' => $filtered->where('jenis_kelamin', 'Perempuan')->count(),
                'Total' => $filtered->count()
            ];
        }
        
        // Rolled up table for PNS (I, II, III, IV)
        $tableGolPnsSummary = ['I' => ['Laki-laki'=>0, 'Perempuan'=>0], 'II' => ['Laki-laki'=>0, 'Perempuan'=>0], 'III' => ['Laki-laki'=>0, 'Perempuan'=>0], 'IV' => ['Laki-laki'=>0, 'Perempuan'=>0]];
        foreach ($dataGolonganPns as $gol => $counts) {
            $mainGol = strtoupper(explode('/', $gol)[0]); // e.g., 'III/a' -> 'III'
            if (isset($tableGolPnsSummary[$mainGol])) {
                $tableGolPnsSummary[$mainGol]['Laki-laki'] += $counts['Laki-laki'];
                $tableGolPnsSummary[$mainGol]['Perempuan'] += $counts['Perempuan'];
            }
        }

        // 7. Pangkat/Golongan PPPK (Chart & Table)
        $pppkEmployees = $employees->whereIn('status_pegawai', ['PPPK', 'PPPK Paruh Waktu']);
        $dataGolonganPppk = [];
        $uniqueGolPppk = $pppkEmployees->pluck('golongan')->filter(fn($val) => !empty(trim($val)))->unique()->sort()->values();
        foreach ($uniqueGolPppk as $gol) {
            $filtered = $pppkEmployees->where('golongan', $gol);
            $dataGolonganPppk[$gol] = [
                'Laki-laki' => $filtered->where('jenis_kelamin', 'Laki-laki')->count(),
                'Perempuan' => $filtered->where('jenis_kelamin', 'Perempuan')->count(),
                'Total' => $filtered->count()
            ];
        }

        // 8. Pendidikan
        $dataPendidikan = [];
        $uniquePendidikan = $employees->pluck('pendidikan')->map(fn($v) => trim($v))->map(fn($v) => empty($v) || $v === '-' ? 'Pendidikan Belum Terinput' : $v)->unique();

        $pendOrder = ['Pendidikan Belum Terinput', 'SD', 'SLTP', 'SLTA', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3'];
        $sortedPend = $uniquePendidikan->sort(function($a, $b) use ($pendOrder) {
            $posA = array_search($a, $pendOrder);
            $posB = array_search($b, $pendOrder);
            if ($posA === false) $posA = 999;
            if ($posB === false) $posB = 999;
            
            if ($posA === $posB) {
                return strcmp($a, $b);
            }
            return $posA <=> $posB;
        })->values();

        foreach ($sortedPend as $pend) {
            $filtered = $employees->filter(function($i) use ($pend) {
                $p = trim($i->pendidikan);
                if (empty($p) || $p === '-') $p = 'Pendidikan Belum Terinput';
                return $p === $pend;
            });

            // Prevent blank rows
            if ($filtered->count() == 0) continue;

            $dataPendidikan[$pend] = [
                'PNS' => $filtered->where('status_pegawai', 'PNS')->count(),
                'CPNS' => $filtered->where('status_pegawai', 'CPNS')->count(),
                'PPPK' => $filtered->where('status_pegawai', 'PPPK')->count(),
                'PPPK Paruh Waktu' => $filtered->where('status_pegawai', 'PPPK Paruh Waktu')->count(),
                'Total' => $filtered->count()
            ];
        }

        // 9. Generasi (Parse Age carefully)
        $dataGenerasi = [
            'Gen Z (14-29)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
            'Milenial (30-45)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
            'Generasi X (46-61)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
            'Baby Boomer (62-80)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
            'Lainnya' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0]
        ];

        foreach ($employees as $emp) {
            // Extract the first block of digits which is the "Tahun"
            preg_match('/^(\d+)/', trim($emp->umur), $matches);
            $ageInt = isset($matches[1]) ? (int) $matches[1] : 0;
            
            $gen = 'Lainnya';
            if ($ageInt >= 14 && $ageInt <= 29) $gen = 'Gen Z (14-29)';
            elseif ($ageInt >= 30 && $ageInt <= 45) $gen = 'Milenial (30-45)';
            elseif ($ageInt >= 46 && $ageInt <= 61) $gen = 'Generasi X (46-61)';
            elseif ($ageInt >= 62 && $ageInt <= 80) $gen = 'Baby Boomer (62-80)';

            $statusKey = $emp->status_pegawai;
            if (in_array($statusKey, $types)) {
                $dataGenerasi[$gen][$statusKey]++;
            }
            $dataGenerasi[$gen]['Total']++;
        }

        // 10. Eselon I per ASN Table (Sort Descending by Name)
        $eselon1Units = $employees->pluck('unit_kerja_eselon_1')->filter()->unique()->sortDesc()->values();
        $tableEselon1Asn = [];
        foreach ($eselon1Units as $ue1) {
            $filtered = $employees->where('unit_kerja_eselon_1', $ue1);
            $tableEselon1Asn[$ue1] = [
                'PNS' => $filtered->where('status_pegawai', 'PNS')->count(),
                'CPNS' => $filtered->where('status_pegawai', 'CPNS')->count(),
                'PPPK' => $filtered->where('status_pegawai', 'PPPK')->count(),
                'PPPK Paruh Waktu' => $filtered->where('status_pegawai', 'PPPK Paruh Waktu')->count(),
                'Struktural' => $filtered->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === 'Struktural')->count(),
                'Fungsional' => $filtered->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === 'Fungsional')->count(),
                'Pelaksana' => $filtered->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === 'Pelaksana')->count(),
                'Total' => $filtered->count()
            ];
        }

        // 11. Data Struktural per Eselon I (Sort Descending by Name)
        $strukturalFilter = $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === 'Struktural');
        $uniqueEselonStruktural = $strukturalFilter->pluck('jenis_jabatan')->filter()->unique()->sort()->values();
        $tableStrukturalEselon1 = [];
        foreach ($eselon1Units as $ue1) {
            $row = [];
            $ue1Eemps = $strukturalFilter->where('unit_kerja_eselon_1', $ue1);
            foreach ($uniqueEselonStruktural as $esLevel) {
                $row[$esLevel] = $ue1Eemps->where('jenis_jabatan', $esLevel)->count();
            }
            $row['Total'] = $ue1Eemps->count();
            $tableStrukturalEselon1[$ue1] = $row;
        }

        // 12. Data ASN per Kelompok Fungsional (Using jabatan_murni e.g. Pranata Komputer)
        $fungsionalFilter = $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === 'Fungsional');
        
        $jjgOrder = ['Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'];
        $uniqueJjg = $fungsionalFilter->pluck('jabatan')->filter(fn($val) => !empty(trim($val)))->unique()->sort(function($a, $b) use ($jjgOrder) {
            $posA = array_search(trim((string)$a), $jjgOrder);
            $posB = array_search(trim((string)$b), $jjgOrder);
            if ($posA === false) $posA = 999;
            if ($posB === false) $posB = 999;
            
            if ($posA === $posB) {
                return strcmp((string)$a, (string)$b);
            }
            return $posA <=> $posB;
        })->values();
        
        // Use 'jabatan_murni' instead of 'kelompok_fungsional' to get "Pranata Komputer" etc.
        $uniqueKelompok = $fungsionalFilter->pluck('jabatan_murni')->filter(fn($val) => !empty(trim($val)))->unique()->sort()->values();
        
        $tableKelompokFungsional = [];
        foreach ($uniqueKelompok as $kel) {
            $row = [];
            $kelEmps = $fungsionalFilter->where('jabatan_murni', $kel);
            foreach ($uniqueJjg as $jjg) {
                $row[$jjg] = $kelEmps->where('jabatan', $jjg)->count();
            }
            $row['Total'] = $kelEmps->count();
            if ($row['Total'] > 0) {
                $tableKelompokFungsional[$kel] = $row;
            }
        }

        // 13. Data ASN per Kelompok Fungsional per Eselon I dan Satker
        $tableFungsionalDetail = [];
        foreach ($eselon1Units as $ue1) {
            $ue1Fung = $fungsionalFilter->where('unit_kerja_eselon_1', $ue1);
            if ($ue1Fung->count() === 0) continue;

            $tableFungsionalDetail[$ue1] = [];
            $satkers = $ue1Fung->pluck('unit_kerja')->filter()->unique()->sort()->values();
            
            foreach ($satkers as $sat) {
                $satEmps = $ue1Fung->where('unit_kerja', $sat);
                if ($satEmps->count() === 0) continue;

                // Group by jabatan_murni
                $satKelompoks = $satEmps->pluck('jabatan_murni')->filter(fn($val) => !empty(trim($val)))->unique()->sort()->values();
                $satData = [];

                foreach ($satKelompoks as $kel) {
                    $kelEmps = $satEmps->where('jabatan_murni', $kel);
                    $row = [];
                    foreach ($uniqueJjg as $jjg) {
                        $row[$jjg] = $kelEmps->where('jabatan', $jjg)->count();
                    }
                    $row['Total'] = $kelEmps->count();
                    if ($row['Total'] > 0) {
                        $satData[$kel] = $row;
                    }
                }
                
                // Add Satker total
                $satTotalRow = [];
                foreach ($uniqueJjg as $jjg) {
                    $satTotalRow[$jjg] = $satEmps->where('jabatan', $jjg)->count();
                }
                $satTotalRow['Total'] = $satEmps->count();
                $satData['Total Satker'] = $satTotalRow;

                $tableFungsionalDetail[$ue1][$sat] = $satData;
            }
        }

        return view('pages.statistik', compact(
            'statisticsPeriod', 'availablePeriods',
            'totalAsn', 'totalPns', 'totalCpns', 'totalPppk', 'totalPppkParuhWaktu',
            'dataJenisKelamin', 'dataLokasiKerja', 'dataPegawaiGender', 'dataLokasiGender',
            'tableAsnPerAsn', 'dataGolonganPns', 'tableGolPnsSummary', 'dataGolonganPppk', 'dataPendidikan',
            'dataGenerasi', 'tableEselon1Asn', 'tableStrukturalEselon1', 'uniqueEselonStruktural',
            'tableKelompokFungsional', 'uniqueJjg', 'tableFungsionalDetail'
        ));
    }
}
