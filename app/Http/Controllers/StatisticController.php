<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\StatisticSummary;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        ini_set('memory_limit', '512M');

        $activeSettingsPeriod = Setting::where('key', 'statistics_period')->value('value');
        $statisticsPeriod = $request->query('periode') ?: ($activeSettingsPeriod ?? 'Tahun Ini');

        // Cache available periods for 1 hour
        $availablePeriods = Cache::remember('statistics_available_periods', 3600, function () {
            $availablePeriodsFromEmployees = Employee::select('periode')->distinct()->pluck('periode')->toArray();
            $availablePeriodsFromSummaries = StatisticSummary::select('periode')->distinct()->pluck('periode')->toArray();
            return array_values(array_unique(array_merge($availablePeriodsFromEmployees, $availablePeriodsFromSummaries)));
        });

        // Cache statistics result for 1 hour per period
        $cacheKey = 'statistics_page_data_' . Str::slug($statisticsPeriod);

        $viewData = Cache::remember($cacheKey, 3600, function () use ($statisticsPeriod, $availablePeriods) {
            // Check if there is summary data for this period
            $summaries = StatisticSummary::where('periode', $statisticsPeriod)
                ->get()
                ->keyBy('category');

            if ($summaries->isNotEmpty()) {
                // Mode A: Summary Mode (fast load from json)
                $totalAsn = (int) ($summaries->get('total_asn')->data ?? 0);
                $totalPns = (int) ($summaries->get('total_pns')->data ?? 0);
                $totalCpns = (int) ($summaries->get('total_cpns')->data ?? 0);
                $totalPppk = (int) ($summaries->get('total_pppk')->data ?? 0);
                $totalPppkParuhWaktu = (int) ($summaries->get('total_pppk_paruh_waktu')->data ?? 0);

                $dataJenisKelamin = $summaries->has('data_jenis_kelamin') ? json_decode($summaries->get('data_jenis_kelamin')->data, true) : [];
                $dataLokasiKerja = $summaries->has('data_lokasi_kerja') ? json_decode($summaries->get('data_lokasi_kerja')->data, true) : [];
                $dataPegawaiGender = $summaries->has('data_pegawai_gender') ? json_decode($summaries->get('data_pegawai_gender')->data, true) : [];
                $dataLokasiGender = $summaries->has('data_lokasi_gender') ? json_decode($summaries->get('data_lokasi_gender')->data, true) : [];
                $tableAsnPerAsn = $summaries->has('table_asn_per_asn') ? json_decode($summaries->get('table_asn_per_asn')->data, true) : [];
                $dataGolonganPns = $summaries->has('data_golongan_pns') ? json_decode($summaries->get('data_golongan_pns')->data, true) : [];
                $dataGolonganPppk = $summaries->has('data_golongan_pppk') ? json_decode($summaries->get('data_golongan_pppk')->data, true) : [];
                $dataPendidikan = $summaries->has('data_pendidikan') ? json_decode($summaries->get('data_pendidikan')->data, true) : [];
                $dataGenerasi = $summaries->has('data_generasi') ? json_decode($summaries->get('data_generasi')->data, true) : [];
                $tableEselon1Asn = $summaries->has('table_eselon1_asn') ? json_decode($summaries->get('table_eselon1_asn')->data, true) : [];
                $tableStrukturalEselon1 = $summaries->has('table_struktural_eselon1') ? json_decode($summaries->get('table_struktural_eselon1')->data, true) : [];
                $tableKelompokFungsional = $summaries->has('table_kelompok_fungsional') ? json_decode($summaries->get('table_kelompok_fungsional')->data, true) : [];
                $tableFungsionalDetail = $summaries->has('table_fungsional_detail') ? json_decode($summaries->get('table_fungsional_detail')->data, true) : [];

                // Compute auxiliary variables
                $tableGolPnsSummary = ['I' => ['Laki-laki'=>0, 'Perempuan'=>0], 'II' => ['Laki-laki'=>0, 'Perempuan'=>0], 'III' => ['Laki-laki'=>0, 'Perempuan'=>0], 'IV' => ['Laki-laki'=>0, 'Perempuan'=>0]];
                foreach ($dataGolonganPns as $gol => $counts) {
                    $mainGol = strtoupper(explode('/', $gol)[0]);
                    if (isset($tableGolPnsSummary[$mainGol])) {
                        $tableGolPnsSummary[$mainGol]['Laki-laki'] += ($counts['Laki-laki'] ?? 0);
                        $tableGolPnsSummary[$mainGol]['Perempuan'] += ($counts['Perempuan'] ?? 0);
                    }
                }

                $uniqueEselonStruktural = collect($tableStrukturalEselon1)->flatMap(function($row) {
                    return array_keys(array_diff_key($row, ['Total' => 0]));
                })->unique()->sort()->values();

                $uniqueJjg = ['Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'];

                $geoStats = $this->computeProvinceDistribution();
                $dataProvinsi = $summaries->has('data_provinsi') 
                    ? json_decode($summaries->get('data_provinsi')->data, true) 
                    : $geoStats['provinces'];
                $dataPulau = $geoStats['islands'];

            } else {
                // Mode B: Detail Mode (query dynamic from employees table)
                $baseQuery = Employee::when($statisticsPeriod !== 'Tahun Ini' && in_array($statisticsPeriod, $availablePeriods), function ($q) use ($statisticsPeriod) {
                    return $q->where('periode', $statisticsPeriod);
                });

                $employees = $baseQuery->select(
                    'status_pegawai', 'jenis_kelamin', 'jenis_kantor', 'jenis_jabatan', 
                    'golongan', 'pendidikan', 'umur', 'unit_kerja_eselon_1', 
                    'kelompok_fungsional', 'jabatan', 'unit_kerja', 'nama_jabatan', 'jabatan_murni',
                    'kedudukan_prop', 'kedudukan_kota'
                )->get();

                if ($employees->isEmpty()) {
                    // Return empty default state
                    $totalAsn = 0;
                    $totalPns = 0;
                    $totalCpns = 0;
                    $totalPppk = 0;
                    $totalPppkParuhWaktu = 0;
                    $dataJenisKelamin = [];
                    $dataLokasiKerja = [];
                    $dataPegawaiGender = [];
                    $dataLokasiGender = [];
                    $tableAsnPerAsn = [];
                    $dataGolonganPns = [];
                    $tableGolPnsSummary = ['I' => ['Laki-laki'=>0, 'Perempuan'=>0], 'II' => ['Laki-laki'=>0, 'Perempuan'=>0], 'III' => ['Laki-laki'=>0, 'Perempuan'=>0], 'IV' => ['Laki-laki'=>0, 'Perempuan'=>0]];
                    $dataGolonganPppk = [];
                    $dataPendidikan = [];
                    $dataGenerasi = [];
                    $tableEselon1Asn = [];
                    $tableStrukturalEselon1 = [];
                    $uniqueEselonStruktural = collect([]);
                    $tableKelompokFungsional = [];
                    $uniqueJjg = ['Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'];
                    $tableFungsionalDetail = [];
                    $geoStats = $this->computeProvinceDistribution(collect([]));
                    $dataProvinsi = $geoStats['provinces'];
                    $dataPulau = $geoStats['islands'];
                } else {
                    $types = ['PNS', 'CPNS', 'PPPK', 'PPPK Paruh Waktu'];

                    $totalAsn = $employees->count();
                    $totalPns = $employees->where('status_pegawai', 'PNS')->count();
                    $totalCpns = $employees->where('status_pegawai', 'CPNS')->count();
                    $totalPppk = $employees->where('status_pegawai', 'PPPK')->count();
                    $totalPppkParuhWaktu = $employees->where('status_pegawai', 'PPPK Paruh Waktu')->count();

                    $dataJenisKelamin = $employees->countBy('jenis_kelamin');
                    $dataLokasiKerja = $employees->countBy('jenis_kantor');

                    $dataPegawaiGender = [];
                    foreach ($types as $type) {
                        $filtered = $employees->where('status_pegawai', $type);
                        $dataPegawaiGender[$type] = [
                            'Laki-laki' => $filtered->where('jenis_kelamin', 'Laki-laki')->count(),
                            'Perempuan' => $filtered->where('jenis_kelamin', 'Perempuan')->count(),
                            'Total' => $filtered->count()
                        ];
                    }

                    $uniqueKantor = $employees->pluck('jenis_kantor')->filter(fn($val) => !empty(trim((string)$val)))->unique()->values();
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

                    $jabatanCategories = ['Struktural', 'Fungsional', 'Pelaksana'];
                    $tableAsnPerAsn = [];
                    foreach ($jabatanCategories as $cat) {
                        $tableAsnPerAsn[$cat] = [
                            'Laki-laki' => $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === $cat)->where('jenis_kelamin', 'Laki-laki')->count(),
                            'Perempuan' => $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === $cat)->where('jenis_kelamin', 'Perempuan')->count()
                        ];
                    }

                    $pnsEmployees = $employees->whereIn('status_pegawai', ['PNS', 'CPNS']);
                    $dataGolonganPns = []; 
                    $uniqueGolPns = $pnsEmployees->pluck('golongan')->filter(fn($val) => !empty(trim((string)$val)))->unique()->sort()->values();
                    foreach ($uniqueGolPns as $gol) {
                        $filtered = $pnsEmployees->where('golongan', $gol);
                        $dataGolonganPns[$gol] = [
                            'Laki-laki' => $filtered->where('jenis_kelamin', 'Laki-laki')->count(),
                            'Perempuan' => $filtered->where('jenis_kelamin', 'Perempuan')->count(),
                            'Total' => $filtered->count()
                        ];
                    }
                    
                    $tableGolPnsSummary = ['I' => ['Laki-laki'=>0, 'Perempuan'=>0], 'II' => ['Laki-laki'=>0, 'Perempuan'=>0], 'III' => ['Laki-laki'=>0, 'Perempuan'=>0], 'IV' => ['Laki-laki'=>0, 'Perempuan'=>0]];
                    foreach ($dataGolonganPns as $gol => $counts) {
                        $mainGol = strtoupper(explode('/', $gol)[0]);
                        if (isset($tableGolPnsSummary[$mainGol])) {
                            $tableGolPnsSummary[$mainGol]['Laki-laki'] += $counts['Laki-laki'];
                            $tableGolPnsSummary[$mainGol]['Perempuan'] += $counts['Perempuan'];
                        }
                    }

                    $pppkEmployees = $employees->whereIn('status_pegawai', ['PPPK', 'PPPK Paruh Waktu']);
                    $dataGolonganPppk = [];
                    $pppkOrder = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII'];

                    $uniqueGolPppk = $pppkEmployees->pluck('golongan')
                        ->map(fn($v) => trim((string)$v))
                        ->filter(function($v) use ($pppkOrder) {
                            return in_array(strtoupper($v), $pppkOrder);
                        })
                        ->unique()
                        ->sort(function($a, $b) use ($pppkOrder) {
                            $posA = array_search(strtoupper($a), $pppkOrder);
                            $posB = array_search(strtoupper($b), $pppkOrder);
                            return ($posA === false ? 999 : $posA) <=> ($posB === false ? 999 : $posB);
                        })
                        ->values();

                    foreach ($uniqueGolPppk as $gol) {
                        $filtered = $pppkEmployees->where('golongan', $gol);
                        $dataGolonganPppk[$gol] = [
                            'Laki-laki' => $filtered->where('jenis_kelamin', 'Laki-laki')->count(),
                            'Perempuan' => $filtered->where('jenis_kelamin', 'Perempuan')->count(),
                            'Total' => $filtered->count()
                        ];
                    }

                    $dataPendidikan = [];
                    $validLevels = ['SD', 'SLTP', 'SLTA', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3'];
                    $pendOrder = ['SD', 'SLTP', 'SLTA', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3', 'Pendidikan Belum Terinput'];

                    $uniquePendidikan = $employees->pluck('pendidikan')
                        ->map(fn($v) => strtoupper(trim((string)$v)))
                        ->map(fn($v) => in_array($v, $validLevels) ? $v : 'Pendidikan Belum Terinput')
                        ->unique()
                        ->sort(function($a, $b) use ($pendOrder) {
                            $posA = array_search($a, $pendOrder);
                            $posB = array_search($b, $pendOrder);
                            return ($posA === false ? 999 : $posA) <=> ($posB === false ? 999 : $posB);
                        })
                        ->values();

                    foreach ($uniquePendidikan as $pend) {
                        $filtered = $employees->filter(function($i) use ($pend, $validLevels) {
                            $p = strtoupper(trim((string)$i->pendidikan));
                            $category = in_array($p, $validLevels) ? $p : 'Pendidikan Belum Terinput';
                            return $category === $pend;
                        });
                        if ($filtered->count() == 0) continue;
                        $dataPendidikan[$pend] = [
                            'PNS' => $filtered->where('status_pegawai', 'PNS')->count(),
                            'CPNS' => $filtered->where('status_pegawai', 'CPNS')->count(),
                            'PPPK' => $filtered->where('status_pegawai', 'PPPK')->count(),
                            'PPPK Paruh Waktu' => $filtered->where('status_pegawai', 'PPPK Paruh Waktu')->count(),
                            'Total' => $filtered->count()
                        ];
                    }

                    $dataGenerasi = [
                        'Gen Z (14-29)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
                        'Milenial (30-45)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
                        'Generasi X (46-61)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
                        'Baby Boomer (62-80)' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0],
                        'Lainnya' => ['PNS'=>0, 'CPNS'=>0, 'PPPK'=>0, 'PPPK Paruh Waktu'=>0, 'Total'=>0]
                    ];

                    foreach ($employees as $emp) {
                        preg_match('/^(\d+)/', trim((string)$emp->umur), $matches);
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

                    $fungsionalFilter = $employees->filter(fn($i) => $categorizeJabatan($i->jenis_jabatan) === 'Fungsional');
                    $jjgOrder = ['Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'];
                    $uniqueJjg = $fungsionalFilter->pluck('jabatan')->filter(fn($val) => !empty(trim((string)$val)))->unique()->sort(function($a, $b) use ($jjgOrder) {
                        $posA = array_search(trim((string)$a), $jjgOrder);
                        $posB = array_search(trim((string)$b), $jjgOrder);
                        if ($posA === false) $posA = 999;
                        if ($posB === false) $posB = 999;
                        return $posA === $posB ? strcmp((string)$a, (string)$b) : ($posA <=> $posB);
                    })->values();
                    
                    $uniqueKelompok = $fungsionalFilter->pluck('jabatan_murni')->filter(fn($val) => !empty(trim((string)$val)))->unique()->sort()->values();
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

                    $tableFungsionalDetail = [];
                    foreach ($eselon1Units as $ue1) {
                        $ue1Fung = $fungsionalFilter->where('unit_kerja_eselon_1', $ue1);
                        if ($ue1Fung->count() === 0) continue;

                        $tableFungsionalDetail[$ue1] = [];
                        $satkers = $ue1Fung->pluck('unit_kerja')->filter()->unique()->sort()->values();
                        
                        foreach ($satkers as $sat) {
                            $satEmps = $ue1Fung->where('unit_kerja', $sat);
                            if ($satEmps->count() === 0) continue;

                            $satKelompoks = $satEmps->pluck('jabatan_murni')->filter(fn($val) => !empty(trim((string)$val)))->unique()->sort()->values();
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
                            
                            $satTotalRow = [];
                            foreach ($uniqueJjg as $jjg) {
                                $satTotalRow[$jjg] = $satEmps->where('jabatan', $jjg)->count();
                            }
                            $satTotalRow['Total'] = $satEmps->count();
                            $satData['Total Satker'] = $satTotalRow;

                            $tableFungsionalDetail[$ue1][$sat] = $satData;
                        }
                    }
                }

                $geoStats = $this->computeProvinceDistribution($employees);
                $dataProvinsi = $geoStats['provinces'];
                $dataPulau = $geoStats['islands'];
            }

            return compact(
                'totalAsn', 'totalPns', 'totalCpns', 'totalPppk', 'totalPppkParuhWaktu',
                'dataJenisKelamin', 'dataLokasiKerja', 'dataPegawaiGender', 'dataLokasiGender',
                'tableAsnPerAsn', 'dataGolonganPns', 'tableGolPnsSummary', 'dataGolonganPppk', 'dataPendidikan',
                'dataGenerasi', 'tableEselon1Asn', 'tableStrukturalEselon1', 'uniqueEselonStruktural',
                'tableKelompokFungsional', 'uniqueJjg', 'tableFungsionalDetail', 'dataProvinsi', 'dataPulau'
            );
        });

        return view('pages.statistik', array_merge([
            'statisticsPeriod' => $statisticsPeriod,
            'availablePeriods' => $availablePeriods,
        ], $viewData));
    }

    public function normalizeProvinceName($prop)
    {
        if (!$prop) return 'DKI Jakarta';
        
        $p = strtolower(trim($prop));
        $p = preg_replace('/^dki\.\s*/i', 'dki ', $p);
        $p = preg_replace('/^d\.i\.\s*/i', 'di ', $p);
        $p = preg_replace('/^d\.i\s*/i', 'di ', $p);
        $p = preg_replace('/^kep\.\s*/i', 'kepulauan ', $p);

        if (str_contains($p, 'jakarta')) return 'DKI Jakarta';
        if (str_contains($p, 'yogyakarta') || str_contains($p, 'jogja')) return 'DI Yogyakarta';
        if (str_contains($p, 'aceh')) return 'Aceh';
        if (str_contains($p, 'sumatera utara')) return 'Sumatera Utara';
        if (str_contains($p, 'sumatera barat')) return 'Sumatera Barat';
        if (str_contains($p, 'kepulauan riau') || str_contains($p, 'kep. riau')) return 'Kepulauan Riau';
        if (str_contains($p, 'riau')) return 'Riau';
        if (str_contains($p, 'jambi')) return 'Jambi';
        if (str_contains($p, 'sumatera selatan')) return 'Sumatera Selatan';
        if (str_contains($p, 'bengkulu')) return 'Bengkulu';
        if (str_contains($p, 'lampung')) return 'Lampung';
        if (str_contains($p, 'bangka')) return 'Bangka Belitung';
        if (str_contains($p, 'banten')) return 'Banten';
        if (str_contains($p, 'jawa barat')) return 'Jawa Barat';
        if (str_contains($p, 'jawa tengah')) return 'Jawa Tengah';
        if (str_contains($p, 'jawa timur')) return 'Jawa Timur';
        if (str_contains($p, 'bali')) return 'Bali';
        if (str_contains($p, 'nusa tenggara barat') || str_contains($p, 'ntb')) return 'Nusa Tenggara Barat';
        if (str_contains($p, 'nusa tenggara timur') || str_contains($p, 'ntt')) return 'Nusa Tenggara Timur';
        if (str_contains($p, 'kalimantan barat')) return 'Kalimantan Barat';
        if (str_contains($p, 'kalimantan tengah')) return 'Kalimantan Tengah';
        if (str_contains($p, 'kalimantan selatan')) return 'Kalimantan Selatan';
        if (str_contains($p, 'kalimantan timur')) return 'Kalimantan Timur';
        if (str_contains($p, 'kalimantan utara')) return 'Kalimantan Utara';
        if (str_contains($p, 'sulawesi utara')) return 'Sulawesi Utara';
        if (str_contains($p, 'gorontalo')) return 'Gorontalo';
        if (str_contains($p, 'sulawesi tengah')) return 'Sulawesi Tengah';
        if (str_contains($p, 'sulawesi barat')) return 'Sulawesi Barat';
        if (str_contains($p, 'sulawesi selatan')) return 'Sulawesi Selatan';
        if (str_contains($p, 'sulawesi tenggara')) return 'Sulawesi Tenggara';
        if (str_contains($p, 'maluku utara')) return 'Maluku Utara';
        if (str_contains($p, 'maluku')) return 'Maluku';
        if (str_contains($p, 'papua barat daya')) return 'Papua Barat Daya';
        if (str_contains($p, 'papua barat')) return 'Papua Barat';
        if (str_contains($p, 'papua tengah')) return 'Papua Tengah';
        if (str_contains($p, 'papua pegunungan')) return 'Papua Pegunungan';
        if (str_contains($p, 'papua selatan')) return 'Papua Selatan';
        if (str_contains($p, 'papua')) return 'Papua';

        return trim($prop);
    }

    public function computeProvinceDistribution($employees = null)
    {
        if ($employees === null) {
            $employees = Employee::select(
                'unit_kerja', 'jenis_kantor', 'status_pegawai', 'jenis_kelamin', 
                'unit_kerja_eselon_1', 'kedudukan_prop', 'kedudukan_kota'
            )->get();
        }

        $provincesConfig = [
            'DKI Jakarta' => ['lat' => -6.2088, 'lng' => 106.8456, 'keywords' => ['dki', 'jakarta', 'kepulauan seribu', 'biro', 'direktorat', 'sekretariat', 'inspektorat', 'pusat']],
            'Aceh' => ['lat' => 4.6951, 'lng' => 96.7494, 'keywords' => ['aceh']],
            'Sumatera Utara' => ['lat' => 2.1154, 'lng' => 99.5451, 'keywords' => ['sumatera utara', 'medan', 'leuser']],
            'Sumatera Barat' => ['lat' => -0.7399, 'lng' => 100.8000, 'keywords' => ['sumatera barat', 'padang', 'siberut']],
            'Riau' => ['lat' => 0.5071, 'lng' => 101.4478, 'keywords' => ['riau', 'pekanbaru', 'tesso nilo']],
            'Kepulauan Riau' => ['lat' => 3.9456, 'lng' => 108.1428, 'keywords' => ['kepulauan riau', 'duriangkang', 'batam', 'tanjungpinang']],
            'Jambi' => ['lat' => -1.4852, 'lng' => 103.6164, 'keywords' => ['jambi', 'berbak']],
            'Sumatera Selatan' => ['lat' => -3.3199, 'lng' => 104.9147, 'keywords' => ['sumatera selatan', 'palembang', 'sembilang']],
            'Bengkulu' => ['lat' => -3.8004, 'lng' => 102.2655, 'keywords' => ['bengkulu', 'kerinci seblat']],
            'Lampung' => ['lat' => -4.5586, 'lng' => 105.4068, 'keywords' => ['lampung', 'way kambas', 'bukit barisan']],
            'Bangka Belitung' => ['lat' => -2.7411, 'lng' => 106.4406, 'keywords' => ['bangka', 'belitung']],
            'Banten' => ['lat' => -6.4058, 'lng' => 106.0640, 'keywords' => ['banten', 'ujung kulon', 'serang']],
            'Jawa Barat' => ['lat' => -6.9175, 'lng' => 107.6191, 'keywords' => ['jawa barat', 'bandung', 'bogor', 'gede pangrango', 'ciremai']],
            'Jawa Tengah' => ['lat' => -7.1510, 'lng' => 110.1403, 'keywords' => ['jawa tengah', 'semarang', 'merbabu', 'merapi', 'karimunjawa']],
            'DI Yogyakarta' => ['lat' => -7.7956, 'lng' => 110.3695, 'keywords' => ['yogyakarta', 'jogja']],
            'Jawa Timur' => ['lat' => -7.5360, 'lng' => 112.2384, 'keywords' => ['jawa timur', 'surabaya', 'baluran', 'bromo', 'meru betiri', 'alas purwo']],
            'Bali' => ['lat' => -8.4095, 'lng' => 115.1889, 'keywords' => ['bali', 'denpasar']],
            'Nusa Tenggara Barat' => ['lat' => -8.6529, 'lng' => 117.3616, 'keywords' => ['nusa tenggara barat', 'ntb', 'mataram', 'rinjani']],
            'Nusa Tenggara Timur' => ['lat' => -8.6574, 'lng' => 121.0794, 'keywords' => ['nusa tenggara timur', 'ntt', 'komodo', 'kupang', 'kelimutu']],
            'Kalimantan Barat' => ['lat' => -0.0863, 'lng' => 109.3333, 'keywords' => ['kalimantan barat', 'pontianak', 'gunung palung', 'betung kerihun']],
            'Kalimantan Tengah' => ['lat' => -1.6815, 'lng' => 113.3824, 'keywords' => ['kalimantan tengah', 'palangkaraya', 'sebangau', 'tanjung puting']],
            'Kalimantan Selatan' => ['lat' => -3.0926, 'lng' => 115.2838, 'keywords' => ['kalimantan selatan', 'banjarmasin']],
            'Kalimantan Timur' => ['lat' => 0.5387, 'lng' => 116.4194, 'keywords' => ['kalimantan timur', 'samarinda', 'kutai', 'ikn']],
            'Kalimantan Utara' => ['lat' => 3.0731, 'lng' => 116.0414, 'keywords' => ['kalimantan utara', 'tarakan', 'kayan mentarang']],
            'Sulawesi Utara' => ['lat' => 0.6247, 'lng' => 123.9750, 'keywords' => ['sulawesi utara', 'manado', 'boghani']],
            'Gorontalo' => ['lat' => 0.6999, 'lng' => 122.4467, 'keywords' => ['gorontalo', 'nani bogani']],
            'Sulawesi Tengah' => ['lat' => -1.4300, 'lng' => 121.4456, 'keywords' => ['sulawesi tengah', 'palu', 'lore lindu']],
            'Sulawesi Barat' => ['lat' => -2.8441, 'lng' => 119.2321, 'keywords' => ['sulawesi barat', 'mamuju']],
            'Sulawesi Selatan' => ['lat' => -3.6687, 'lng' => 119.9741, 'keywords' => ['sulawesi selatan', 'makassar', 'bantimurung']],
            'Sulawesi Tenggara' => ['lat' => -4.1449, 'lng' => 122.1746, 'keywords' => ['sulawesi tenggara', 'kendari', 'rawa aopa']],
            'Maluku Utara' => ['lat' => 1.5709, 'lng' => 127.8088, 'keywords' => ['maluku utara', 'ternate', 'aketajawe']],
            'Maluku' => ['lat' => -3.2385, 'lng' => 130.1453, 'keywords' => ['maluku', 'ambon', 'manusela']],
            'Papua Barat Daya' => ['lat' => -1.0000, 'lng' => 131.2500, 'keywords' => ['papua barat daya', 'sorong']],
            'Papua Barat' => ['lat' => -1.3361, 'lng' => 133.1747, 'keywords' => ['papua barat', 'manokwari', 'arfak']],
            'Papua Tengah' => ['lat' => -3.5000, 'lng' => 136.5000, 'keywords' => ['papua tengah', 'nabire']],
            'Papua Pegunungan' => ['lat' => -4.1000, 'lng' => 138.9000, 'keywords' => ['papua pegunungan', 'wamena']],
            'Papua Selatan' => ['lat' => -7.0000, 'lng' => 139.5000, 'keywords' => ['papua selatan', 'merauke', 'wasur']],
            'Papua' => ['lat' => -2.5337, 'lng' => 140.7181, 'keywords' => ['papua', 'jayapura', 'lorentz']],
        ];

        $result = [];
        foreach ($provincesConfig as $name => $cfg) {
            $result[$name] = [
                'province' => $name,
                'lat' => $cfg['lat'],
                'lng' => $cfg['lng'],
                'total' => 0,
                'pns' => 0,
                'cpns' => 0,
                'pppk' => 0,
                'pppk_paruh_waktu' => 0,
                'male' => 0,
                'female' => 0,
                'eselon1' => [],
                'satker' => [],
                'kota_list' => [],
            ];
        }

        foreach ($employees as $emp) {
            $matchedProv = null;

            if (!empty($emp->kedudukan_prop)) {
                $matchedProv = $this->normalizeProvinceName($emp->kedudukan_prop);
            }

            if (!$matchedProv || !isset($result[$matchedProv])) {
                $text = strtolower(trim(($emp->unit_kerja ?? '') . ' ' . ($emp->jenis_kantor ?? '')));
                foreach ($provincesConfig as $provName => $cfg) {
                    foreach ($cfg['keywords'] as $kw) {
                        if (str_contains($text, strtolower($kw))) {
                            $matchedProv = $provName;
                            break 2;
                        }
                    }
                }
            }

            if (!$matchedProv || !isset($result[$matchedProv])) {
                $matchedProv = 'DKI Jakarta';
            }

            $status = $emp->status_pegawai;
            $jk = $emp->jenis_kelamin;
            $es1 = trim($emp->unit_kerja_eselon_1 ?? 'Lainnya');
            $sat = trim($emp->unit_kerja ?? 'Lainnya');
            $kota = trim($emp->kedudukan_kota ?? '');

            $result[$matchedProv]['total']++;
            if ($status === 'PNS') $result[$matchedProv]['pns']++;
            elseif ($status === 'CPNS') $result[$matchedProv]['cpns']++;
            elseif ($status === 'PPPK') $result[$matchedProv]['pppk']++;
            elseif ($status === 'PPPK Paruh Waktu') $result[$matchedProv]['pppk_paruh_waktu']++;

            if ($jk === 'Laki-laki') $result[$matchedProv]['male']++;
            elseif ($jk === 'Perempuan') $result[$matchedProv]['female']++;

            if (!empty($es1)) {
                $result[$matchedProv]['eselon1'][$es1] = ($result[$matchedProv]['eselon1'][$es1] ?? 0) + 1;
            }

            if (!empty($sat)) {
                $result[$matchedProv]['satker'][$sat] = ($result[$matchedProv]['satker'][$sat] ?? 0) + 1;
            }

            if (!empty($kota) && !in_array($kota, $result[$matchedProv]['kota_list'])) {
                $result[$matchedProv]['kota_list'][] = $kota;
            }
        }

        $islandMapping = [
            'Sumatera' => ['Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau', 'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Bangka Belitung'],
            'Jawa' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur'],
            'Bali & Nusa Tenggara' => ['Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur'],
            'Kalimantan' => ['Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara'],
            'Sulawesi' => ['Sulawesi Utara', 'Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara'],
            'Maluku' => ['Maluku', 'Maluku Utara'],
            'Papua' => ['Papua', 'Papua Barat', 'Papua Barat Daya', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan'],
        ];

        $dataPulau = [];
        foreach ($islandMapping as $islandName => $provList) {
            $dataPulau[$islandName] = [
                'island' => $islandName,
                'total' => 0,
                'pns' => 0,
                'cpns' => 0,
                'pppk' => 0,
                'pppk_paruh_waktu' => 0,
                'male' => 0,
                'female' => 0,
                'provinces_count' => count($provList),
                'provinces_list' => $provList,
                'provinces_detail' => [],
            ];
        }

        foreach ($result as $provName => &$provData) {
            if (!empty($provData['satker'])) {
                arsort($provData['satker']);
            }
            if (!empty($provData['eselon1'])) {
                arsort($provData['eselon1']);
            }

            $foundIsland = null;
            foreach ($islandMapping as $islandName => $provList) {
                if (in_array($provName, $provList)) {
                    $foundIsland = $islandName;
                    break;
                }
            }

            if ($foundIsland && isset($dataPulau[$foundIsland])) {
                $dataPulau[$foundIsland]['total'] += $provData['total'];
                $dataPulau[$foundIsland]['pns'] += $provData['pns'];
                $dataPulau[$foundIsland]['cpns'] += $provData['cpns'];
                $dataPulau[$foundIsland]['pppk'] += $provData['pppk'];
                $dataPulau[$foundIsland]['pppk_paruh_waktu'] += $provData['pppk_paruh_waktu'];
                $dataPulau[$foundIsland]['male'] += $provData['male'];
                $dataPulau[$foundIsland]['female'] += $provData['female'];
                $dataPulau[$foundIsland]['provinces_detail'][] = $provData;
            }
        }
        unset($provData);

        foreach ($dataPulau as &$pulau) {
            usort($pulau['provinces_detail'], fn($a, $b) => $b['total'] <=> $a['total']);
        }
        unset($pulau);

        uasort($result, fn($a, $b) => $b['total'] <=> $a['total']);
        uasort($dataPulau, fn($a, $b) => $b['total'] <=> $a['total']);

        return [
            'provinces' => array_values($result),
            'islands' => array_values($dataPulau),
        ];
    }
}
