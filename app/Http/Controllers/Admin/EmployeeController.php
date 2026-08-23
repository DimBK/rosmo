<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\StatisticSummary;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmployeeController extends Controller
{
    public function index()
    {
        // Get unique periods with counts from employees (Detail)
        $detailPeriods = Employee::select('periode', DB::raw('count(*) as count'))
            ->groupBy('periode')
            ->get()
            ->map(function($item) {
                return (object)[
                    'periode' => $item->periode,
                    'count' => $item->count,
                    'type' => 'Detail'
                ];
            });

        // Get unique periods with counts from statistic_summaries (Summary)
        $summaryPeriods = StatisticSummary::where('category', 'total_asn')
            ->get()
            ->map(function($item) {
                return (object)[
                    'periode' => $item->periode,
                    'count' => (int) $item->data,
                    'type' => 'Ringkasan'
                ];
            });

        // Merge and sort periods
        $periods = $detailPeriods->concat($summaryPeriods)
            ->sortByDesc('periode')
            ->values();
            
        $statisticsPeriod = Setting::where('key', 'statistics_period')->value('value') ?? 'Belum disetel';
        
        $employeeCount = 0;
        $activeType = 'Tidak ada';
        if ($statisticsPeriod !== 'Belum disetel') {
            $hasSummary = StatisticSummary::where('periode', $statisticsPeriod)->exists();
            if ($hasSummary) {
                $activeType = 'Ringkasan';
                $employeeCount = (int) StatisticSummary::where('periode', $statisticsPeriod)
                    ->where('category', 'total_asn')
                    ->value('data') ?? 0;
            } else {
                $activeType = 'Detail';
                $employeeCount = Employee::where('periode', $statisticsPeriod)->count();
            }
        }
        
        return view('admin.employees.index', compact('employeeCount', 'statisticsPeriod', 'periods', 'activeType'));
    }

    /**
     * Import Detail Pegawai (Mode Detail)
     */
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

            // Replace data only for this specific period (clear both tables for clean overwrite)
            Employee::where('periode', $periode)->delete();
            StatisticSummary::where('periode', $periode)->delete();

            // Update the active statistics period in settings
            Setting::updateOrCreate(
                ['key' => 'statistics_period'],
                ['value' => $periode]
            );

            $insertData = [];
            
            $headerRow = $data[1] ?? [];
            $fieldMapping = $this->mapHeadersToFields($headerRow);

            foreach ($data as $index => $row) {
                if ($index === 1) {
                    continue;
                }

                $record = [
                    'periode' => $periode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $metaData = [];

                foreach ($fieldMapping as $colKey => $field) {
                    $cellVal = trim((string)($row[$colKey] ?? ''));

                    if (str_starts_with($field, '_meta_')) {
                        $metaKey = substr($field, 6);
                        if ($cellVal !== '') {
                            $metaData[$metaKey] = $cellVal;
                        }
                    } else {
                        $record[$field] = $cellVal !== '' ? $cellVal : null;
                    }
                }

                // If record has no kelamin or status_pegawai, skip empty rows
                if (empty($record['jenis_kelamin']) && empty($record['status_pegawai']) && empty($record['unit_kerja'])) {
                    continue;
                }

                // Sanitize record fields against whitelists
                $record = $this->sanitizeEmployeeRecord($record);
                $record['meta_data'] = !empty($metaData) ? json_encode($metaData) : null;

                $insertData[] = $record;

                if (count($insertData) >= 1000) {
                    Employee::insert($insertData);
                    $insertData = [];
                }
            }

            if (count($insertData) > 0) {
                Employee::insert($insertData);
            }

            DB::commit();
            Cache::flush();

            return redirect()->back()->with('success', "Data detail pegawai periode {$periode} berhasil diimpor.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error importing employees detail: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Import Ringkasan Statistik (Mode Summary)
     */
    public function importSummary(Request $request)
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

            DB::beginTransaction();

            // Clear old data for this period (both tables for clean overwrite)
            Employee::where('periode', $periode)->delete();
            StatisticSummary::where('periode', $periode)->delete();

            // Update statistics period setting
            Setting::updateOrCreate(
                ['key' => 'statistics_period'],
                ['value' => $periode]
            );

            // 1. Parse Sheet: Ringkasan
            $sheet1 = $spreadsheet->getSheetByName('Ringkasan');
            if (!$sheet1) throw new \Exception('Sheet "Ringkasan" tidak ditemukan.');
            $data1 = $sheet1->toArray(null, true, true, true);
            
            $totalAsn = 0;
            $totalPns = 0;
            $totalCpns = 0;
            $totalPppk = 0;
            $totalPppkParuhWaktu = 0;
            $dataJenisKelamin = [];
            $dataLokasiKerja = [];

            foreach ($data1 as $idx => $row) {
                if ($idx === 1) continue;
                $kategori = trim($row['A'] ?? '');
                $val = (int) ($row['B'] ?? 0);
                if (empty($kategori)) continue;

                if ($kategori === 'Total Pegawai (ASN)' || $kategori === 'Total Pegawai') {
                    $totalAsn = $val;
                } elseif ($kategori === 'PNS') {
                    $totalPns = $val;
                } elseif ($kategori === 'CPNS') {
                    $totalCpns = $val;
                } elseif ($kategori === 'PPPK') {
                    $totalPppk = $val;
                } elseif ($kategori === 'PPPK Paruh Waktu') {
                    $totalPppkParuhWaktu = $val;
                } elseif (in_array($kategori, ['Laki-laki', 'Perempuan'])) {
                    $dataJenisKelamin[$kategori] = $val;
                } else {
                    $dataLokasiKerja[$kategori] = $val;
                }
            }

            $this->saveSummary($periode, 'total_asn', $totalAsn);
            $this->saveSummary($periode, 'total_pns', $totalPns);
            $this->saveSummary($periode, 'total_cpns', $totalCpns);
            $this->saveSummary($periode, 'total_pppk', $totalPppk);
            $this->saveSummary($periode, 'total_pppk_paruh_waktu', $totalPppkParuhWaktu);
            $this->saveSummary($periode, 'data_jenis_kelamin', $dataJenisKelamin);
            $this->saveSummary($periode, 'data_lokasi_kerja', $dataLokasiKerja);

            // 2. Parse Sheet: Pegawai & Lokasi Gender
            $sheet2 = $spreadsheet->getSheetByName('Pegawai & Lokasi Gender');
            if (!$sheet2) throw new \Exception('Sheet "Pegawai & Lokasi Gender" tidak ditemukan.');
            $data2 = $sheet2->toArray(null, true, true, true);
            
            $dataPegawaiGender = [];
            $dataLokasiGender = [];

            foreach ($data2 as $idx => $row) {
                if ($idx === 1) continue;
                $kategori = trim($row['A'] ?? '');
                $l = (int) ($row['B'] ?? 0);
                $p = (int) ($row['C'] ?? 0);
                if (empty($kategori)) continue;

                if (in_array($kategori, ['PNS', 'CPNS', 'PPPK', 'PPPK Paruh Waktu'])) {
                    $dataPegawaiGender[$kategori] = [
                        'Laki-laki' => $l,
                        'Perempuan' => $p,
                        'Total' => $l + $p
                    ];
                } else {
                    $dataLokasiGender[$kategori] = [
                        'Laki-laki' => $l,
                        'Perempuan' => $p,
                        'Total' => $l + $p
                    ];
                }
            }
            $this->saveSummary($periode, 'data_pegawai_gender', $dataPegawaiGender);
            $this->saveSummary($periode, 'data_lokasi_gender', $dataLokasiGender);

            // 3. Parse Sheet: ASN per Jabatan
            $sheet3 = $spreadsheet->getSheetByName('ASN per Jabatan');
            if (!$sheet3) throw new \Exception('Sheet "ASN per Jabatan" tidak ditemukan.');
            $data3 = $sheet3->toArray(null, true, true, true);
            
            $tableAsnPerAsn = [];
            foreach ($data3 as $idx => $row) {
                if ($idx === 1) continue;
                $jabatan = trim($row['A'] ?? '');
                $l = (int) ($row['B'] ?? 0);
                $p = (int) ($row['C'] ?? 0);
                if (empty($jabatan)) continue;

                $tableAsnPerAsn[$jabatan] = [
                    'Laki-laki' => $l,
                    'Perempuan' => $p
                ];
            }
            $this->saveSummary($periode, 'table_asn_per_asn', $tableAsnPerAsn);

            // 4. Parse Sheet: Golongan PNS
            $sheet4 = $spreadsheet->getSheetByName('Golongan PNS');
            if (!$sheet4) throw new \Exception('Sheet "Golongan PNS" tidak ditemukan.');
            $data4 = $sheet4->toArray(null, true, true, true);
            
            $dataGolonganPns = [];
            foreach ($data4 as $idx => $row) {
                if ($idx === 1) continue;
                $gol = trim($row['A'] ?? '');
                $l = (int) ($row['B'] ?? 0);
                $p = (int) ($row['C'] ?? 0);
                if (empty($gol)) continue;

                $dataGolonganPns[$gol] = [
                    'Laki-laki' => $l,
                    'Perempuan' => $p,
                    'Total' => $l + $p
                ];
            }
            $this->saveSummary($periode, 'data_golongan_pns', $dataGolonganPns);

            // 5. Parse Sheet: Golongan PPPK
            $sheet5 = $spreadsheet->getSheetByName('Golongan PPPK');
            if (!$sheet5) throw new \Exception('Sheet "Golongan PPPK" tidak ditemukan.');
            $data5 = $sheet5->toArray(null, true, true, true);
            
            $dataGolonganPppk = [];
            foreach ($data5 as $idx => $row) {
                if ($idx === 1) continue;
                $gol = trim($row['A'] ?? '');
                $l = (int) ($row['B'] ?? 0);
                $p = (int) ($row['C'] ?? 0);
                if (empty($gol)) continue;

                $dataGolonganPppk[$gol] = [
                    'Laki-laki' => $l,
                    'Perempuan' => $p,
                    'Total' => $l + $p
                ];
            }
            $this->saveSummary($periode, 'data_golongan_pppk', $dataGolonganPppk);

            // 6. Parse Sheet: Pendidikan & Generasi
            $sheet6 = $spreadsheet->getSheetByName('Pendidikan & Generasi');
            if (!$sheet6) throw new \Exception('Sheet "Pendidikan & Generasi" tidak ditemukan.');
            $data6 = $sheet6->toArray(null, true, true, true);
            
            $dataPendidikan = [];
            $dataGenerasi = [];
            foreach ($data6 as $idx => $row) {
                if ($idx === 1) continue;
                $kategori = trim($row['A'] ?? '');
                $pns = (int) ($row['B'] ?? 0);
                $cpns = (int) ($row['C'] ?? 0);
                $pppk = (int) ($row['D'] ?? 0);
                $pppk_pw = (int) ($row['E'] ?? 0);
                $tipe = trim($row['F'] ?? '');
                if (empty($kategori)) continue;

                $rowData = [
                    'PNS' => $pns,
                    'CPNS' => $cpns,
                    'PPPK' => $pppk,
                    'PPPK Paruh Waktu' => $pppk_pw,
                    'Total' => $pns + $cpns + $pppk + $pppk_pw
                ];

                if (strtolower($tipe) === 'generasi') {
                    $dataGenerasi[$kategori] = $rowData;
                } else {
                    $dataPendidikan[$kategori] = $rowData;
                }
            }
            $this->saveSummary($periode, 'data_pendidikan', $dataPendidikan);
            $this->saveSummary($periode, 'data_generasi', $dataGenerasi);

            // 7. Parse Sheet: Eselon I
            $sheet7 = $spreadsheet->getSheetByName('Eselon I');
            if (!$sheet7) throw new \Exception('Sheet "Eselon I" tidak ditemukan.');
            $data7 = $sheet7->toArray(null, true, true, true);
            
            $tableEselon1Asn = [];
            foreach ($data7 as $idx => $row) {
                if ($idx === 1) continue;
                $unit = trim($row['A'] ?? '');
                if (empty($unit)) continue;

                $pns = (int) ($row['B'] ?? 0);
                $cpns = (int) ($row['C'] ?? 0);
                $pppk = (int) ($row['D'] ?? 0);
                $pppk_pw = (int) ($row['E'] ?? 0);
                $struk = (int) ($row['F'] ?? 0);
                $fung = (int) ($row['G'] ?? 0);
                $pelak = (int) ($row['H'] ?? 0);

                $tableEselon1Asn[$unit] = [
                    'PNS' => $pns,
                    'CPNS' => $cpns,
                    'PPPK' => $pppk,
                    'PPPK Paruh Waktu' => $pppk_pw,
                    'Struktural' => $struk,
                    'Fungsional' => $fung,
                    'Pelaksana' => $pelak,
                    'Total' => $pns + $cpns + $pppk + $pppk_pw
                ];
            }
            $this->saveSummary($periode, 'table_eselon1_asn', $tableEselon1Asn);

            // 8. Parse Sheet: Struktural Eselon I
            $sheet8 = $spreadsheet->getSheetByName('Struktural Eselon I');
            if (!$sheet8) throw new \Exception('Sheet "Struktural Eselon I" tidak ditemukan.');
            $data8 = $sheet8->toArray(null, true, true, true);
            
            $tableStrukturalEselon1 = [];
            $eselonHeaders = ['I.a', 'I.b', 'II.a', 'II.b', 'III.a', 'III.b', 'IV.a', 'IV.b', 'V.a'];
            foreach ($data8 as $idx => $row) {
                if ($idx === 1) continue;
                $unit = trim($row['A'] ?? '');
                if (empty($unit)) continue;

                $rowData = [];
                $totalStruk = 0;
                $cols = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                foreach ($cols as $colIdx => $colName) {
                    $levelName = $eselonHeaders[$colIdx];
                    $val = (int) ($row[$colName] ?? 0);
                    $rowData[$levelName] = $val;
                    $totalStruk += $val;
                }
                $rowData['Total'] = $totalStruk;
                $tableStrukturalEselon1[$unit] = $rowData;
            }
            $this->saveSummary($periode, 'table_struktural_eselon1', $tableStrukturalEselon1);

            // 9. Parse Sheet: Kelompok Fungsional
            $sheet9 = $spreadsheet->getSheetByName('Kelompok Fungsional');
            if (!$sheet9) throw new \Exception('Sheet "Kelompok Fungsional" tidak ditemukan.');
            $data9 = $sheet9->toArray(null, true, true, true);
            
            $tableKelompokFungsional = [];
            $jjgHeaders = ['Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'];
            foreach ($data9 as $idx => $row) {
                if ($idx === 1) continue;
                $kelompok = trim($row['A'] ?? '');
                if (empty($kelompok)) continue;

                $rowData = [];
                $totalFung = 0;
                $cols = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
                foreach ($cols as $colIdx => $colName) {
                    $jjgName = $jjgHeaders[$colIdx];
                    $val = (int) ($row[$colName] ?? 0);
                    $rowData[$jjgName] = $val;
                    $totalFung += $val;
                }
                $rowData['Total'] = $totalFung;
                $tableKelompokFungsional[$kelompok] = $rowData;
            }
            $this->saveSummary($periode, 'table_kelompok_fungsional', $tableKelompokFungsional);

            // 10. Parse Sheet: Fungsional Detail
            $sheet10 = $spreadsheet->getSheetByName('Fungsional Detail');
            if (!$sheet10) throw new \Exception('Sheet "Fungsional Detail" tidak ditemukan.');
            $data10 = $sheet10->toArray(null, true, true, true);
            
            $tableFungsionalDetail = [];
            $jjgHeaders = ['Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'];
            foreach ($data10 as $idx => $row) {
                if ($idx === 1) continue;
                $eselon1 = trim($row['A'] ?? '');
                $satker = trim($row['B'] ?? '');
                $kelompok = trim($row['C'] ?? '');
                if (empty($eselon1) || empty($satker) || empty($kelompok)) continue;

                $rowData = [];
                $totalRow = 0;
                $cols = ['D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
                foreach ($cols as $colIdx => $colName) {
                    $jjgName = $jjgHeaders[$colIdx];
                    $val = (int) ($row[$colName] ?? 0);
                    $rowData[$jjgName] = $val;
                    $totalRow += $val;
                }
                $rowData['Total'] = $totalRow;

                if (!isset($tableFungsionalDetail[$eselon1])) {
                    $tableFungsionalDetail[$eselon1] = [];
                }
                if (!isset($tableFungsionalDetail[$eselon1][$satker])) {
                    $tableFungsionalDetail[$eselon1][$satker] = [];
                }
                $tableFungsionalDetail[$eselon1][$satker][$kelompok] = $rowData;
            }

            // Calculate 'Total Satker'
            foreach ($tableFungsionalDetail as $es1 => $satkers) {
                foreach ($satkers as $sat => $satData) {
                    $satTotal = [];
                    $grandSatTotal = 0;
                    foreach ($jjgHeaders as $jjgName) {
                        $satTotal[$jjgName] = 0;
                    }
                    foreach ($satData as $kel => $d) {
                        if ($kel === 'Total Satker') continue;
                        foreach ($jjgHeaders as $jjgName) {
                            $satTotal[$jjgName] += ($d[$jjgName] ?? 0);
                        }
                        $grandSatTotal += ($d['Total'] ?? 0);
                    }
                    $satTotal['Total'] = $grandSatTotal;
                    $tableFungsionalDetail[$es1][$sat]['Total Satker'] = $satTotal;
                }
            }
            $this->saveSummary($periode, 'table_fungsional_detail', $tableFungsionalDetail);

            DB::commit();

            return redirect()->back()->with('success', "Data statistik ringkasan (Summary) periode {$periode} berhasil diimpor.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error importing summaries: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk mode Summary
     */
    public function downloadSummaryTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // 1. Ringkasan
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ringkasan');
        $sheet->fromArray([
            ['Kategori', 'Jumlah'],
            ['Total Pegawai (ASN)', 0],
            ['PNS', 0],
            ['CPNS', 0],
            ['PPPK', 0],
            ['PPPK Paruh Waktu', 0],
            ['Laki-laki', 0],
            ['Perempuan', 0],
            ['Pusat', 0],
            ['Daerah', 0],
        ]);

        // 2. Pegawai & Lokasi Gender
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Pegawai & Lokasi Gender');
        $sheet2->fromArray([
            ['Kategori', 'Laki-laki', 'Perempuan'],
            ['PNS', 0, 0],
            ['CPNS', 0, 0],
            ['PPPK', 0, 0],
            ['PPPK Paruh Waktu', 0, 0],
            ['Pusat', 0, 0],
            ['Daerah', 0, 0],
        ]);

        // 3. ASN per Jabatan
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('ASN per Jabatan');
        $sheet3->fromArray([
            ['Jenis Jabatan', 'Laki-laki', 'Perempuan'],
            ['Struktural', 0, 0],
            ['Fungsional', 0, 0],
            ['Pelaksana', 0, 0],
        ]);

        // 4. Golongan PNS
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Golongan PNS');
        $rowsPNS = [['Golongan', 'Laki-laki', 'Perempuan']];
        foreach (['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'] as $gol) {
            $rowsPNS[] = [$gol, 0, 0];
        }
        $sheet4->fromArray($rowsPNS);

        // 5. Golongan PPPK
        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('Golongan PPPK');
        $rowsPPPK = [['Golongan', 'Laki-laki', 'Perempuan']];
        for ($i = 1; $i <= 17; $i++) {
            $rowsPPPK[] = ['Golongan ' . $i, 0, 0];
        }
        $sheet5->fromArray($rowsPPPK);

        // 6. Pendidikan & Generasi
        $sheet6 = $spreadsheet->createSheet();
        $sheet6->setTitle('Pendidikan & Generasi');
        $sheet6->fromArray([
            ['Kategori', 'PNS', 'CPNS', 'PPPK', 'PPPK Paruh Waktu', 'Tipe'],
            ['SD', 0, 0, 0, 0, 'Pendidikan'],
            ['SLTP', 0, 0, 0, 0, 'Pendidikan'],
            ['SLTA', 0, 0, 0, 0, 'Pendidikan'],
            ['DII', 0, 0, 0, 0, 'Pendidikan'],
            ['DIII', 0, 0, 0, 0, 'Pendidikan'],
            ['DIV', 0, 0, 0, 0, 'Pendidikan'],
            ['S1', 0, 0, 0, 0, 'Pendidikan'],
            ['S2', 0, 0, 0, 0, 'Pendidikan'],
            ['S3', 0, 0, 0, 0, 'Pendidikan'],
            ['Pendidikan Belum Terinput', 0, 0, 0, 0, 'Pendidikan'],
            ['Gen Z (14-29)', 0, 0, 0, 0, 'Generasi'],
            ['Milenial (30-45)', 0, 0, 0, 0, 'Generasi'],
            ['Generasi X (46-61)', 0, 0, 0, 0, 'Generasi'],
            ['Baby Boomer (62-80)', 0, 0, 0, 0, 'Generasi'],
            ['Lainnya', 0, 0, 0, 0, 'Generasi'],
        ]);

        // 7. Eselon I
        $sheet7 = $spreadsheet->createSheet();
        $sheet7->setTitle('Eselon I');
        $sheet7->fromArray([
            ['Unit Eselon I', 'PNS', 'CPNS', 'PPPK', 'PPPK Paruh Waktu', 'Struktural', 'Fungsional', 'Pelaksana'],
            ['Sekretariat Jenderal', 0, 0, 0, 0, 0, 0, 0],
            ['Direktorat Jenderal Planologi Kehutanan dan Tata Lingkungan', 0, 0, 0, 0, 0, 0, 0],
        ]);

        // 8. Struktural Eselon I
        $sheet8 = $spreadsheet->createSheet();
        $sheet8->setTitle('Struktural Eselon I');
        $sheet8->fromArray([
            ['Unit Eselon I', 'I.a', 'I.b', 'II.a', 'II.b', 'III.a', 'III.b', 'IV.a', 'IV.b', 'V.a'],
            ['Sekretariat Jenderal', 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ]);

        // 9. Kelompok Fungsional
        $sheet9 = $spreadsheet->createSheet();
        $sheet9->setTitle('Kelompok Fungsional');
        $sheet9->fromArray([
            ['Kelompok Fungsional (Jabatan Murni)', 'Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'],
            ['Pranata Komputer', 0, 0, 0, 0, 0, 0, 0, 0],
        ]);

        // 10. Fungsional Detail
        $sheet10 = $spreadsheet->createSheet();
        $sheet10->setTitle('Fungsional Detail');
        $sheet10->fromArray([
            ['Unit Eselon I', 'Satker', 'Kelompok Fungsional (Jabatan Murni)', 'Pemula', 'Terampil', 'Mahir', 'Penyelia', 'Pertama', 'Muda', 'Madya', 'Utama'],
            ['Sekretariat Jenderal', 'Biro Kepegawaian', 'Pranata Komputer', 0, 0, 0, 0, 0, 0, 0, 0],
        ]);

        // Auto size columns for all sheets
        foreach ($spreadsheet->getAllSheets() as $sh) {
            foreach (range('A', $sh->getHighestDataColumn()) as $col) {
                $sh->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Template_Import_Statistik_Summary.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName) .'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Dynamically map Excel header titles to database fields.
     */
    private function mapHeadersToFields(array $headerRow): array
    {
        $fieldMapping = [];
        foreach ($headerRow as $colKey => $headerText) {
            if (empty($headerText)) continue;
            $h = strtolower(trim((string)$headerText));

            if (str_contains($h, 'umur') || $h === 'usia') {
                $fieldMapping[$colKey] = 'umur';
            } elseif (str_contains($h, 'kel. usia') || str_contains($h, 'kelompok usia')) {
                $fieldMapping[$colKey] = 'kelompok_umur';
            } elseif (str_contains($h, 'kelamin') || str_contains($h, 'jk')) {
                $fieldMapping[$colKey] = 'jenis_kelamin';
            } elseif (str_contains($h, 'agama')) {
                $fieldMapping[$colKey] = 'agama';
            } elseif (str_contains($h, 'jenis asn') || str_contains($h, 'status pegawai') || str_contains($h, 'status asn')) {
                $fieldMapping[$colKey] = 'status_pegawai';
            } elseif (str_contains($h, 'lokasi kerja') || str_contains($h, 'jenis kantor')) {
                $fieldMapping[$colKey] = 'jenis_kantor';
            } elseif ($h === 'eselon' || str_contains($h, 'jenis jabatan')) {
                $fieldMapping[$colKey] = 'jenis_jabatan';
            } elseif (str_contains($h, 'tkt fgs') || str_contains($h, 'kelompok fungsional')) {
                $fieldMapping[$colKey] = 'kelompok_fungsional';
            } elseif (str_contains($h, 'jjg fgs') || str_contains($h, 'jenjang')) {
                $fieldMapping[$colKey] = 'jabatan';
            } elseif (str_contains($h, 'nama jabatan')) {
                $fieldMapping[$colKey] = 'nama_jabatan';
            } elseif (str_contains($h, 'kel fgs') || str_contains($h, 'jabatan murni')) {
                $fieldMapping[$colKey] = 'jabatan_murni';
            } elseif (str_contains($h, 'eselon 1') || str_contains($h, 'eselon i')) {
                $fieldMapping[$colKey] = 'unit_kerja_eselon_1';
            } elseif (str_contains($h, 'satker') || str_contains($h, 'unit kerja')) {
                $fieldMapping[$colKey] = 'unit_kerja';
            } elseif (str_contains($h, 'kedudukan (prop)') || str_contains($h, 'prop') || str_contains($h, 'provinsi')) {
                $fieldMapping[$colKey] = 'kedudukan_prop';
            } elseif (str_contains($h, 'kedudukan (kota)') || str_contains($h, 'kota') || str_contains($h, 'kabupaten')) {
                $fieldMapping[$colKey] = 'kedudukan_kota';
            } elseif (str_contains($h, 'pddk') || str_contains($h, 'pendidikan')) {
                $fieldMapping[$colKey] = 'pendidikan';
            } elseif (str_contains($h, 'gol') || str_contains($h, 'pangkat')) {
                $fieldMapping[$colKey] = 'golongan';
            } else {
                // Unknown future columns are preserved as meta_data!
                $fieldMapping[$colKey] = '_meta_' . trim((string)$headerText);
            }
        }
        return $fieldMapping;
    }

    /**
     * Strict whitelist sanitizer for employee fields.
     */
    private function sanitizeEmployeeRecord(array $record): array
    {
        $validPendidikan = ['SD', 'SLTP', 'SLTA', 'DII', 'DIII', 'DIV', 'S1', 'S2', 'S3'];
        $validGolonganPns = ['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'];
        $validGolonganPppk = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII'];

        // Validate pendidikan
        $pend = strtoupper(trim((string)($record['pendidikan'] ?? '')));
        $record['pendidikan'] = in_array($pend, $validPendidikan) ? $pend : null;

        // Validate golongan
        $gol = trim((string)($record['golongan'] ?? ''));
        $record['golongan'] = (in_array(strtoupper($gol), $validGolonganPppk) || in_array($gol, $validGolonganPns)) ? $gol : null;

        // Validate status_pegawai
        $status = trim((string)($record['status_pegawai'] ?? ''));
        if (str_contains(strtolower($status), 'paruh')) {
            $record['status_pegawai'] = 'PPPK Paruh Waktu';
        } elseif (str_contains(strtoupper($status), 'PPPK')) {
            $record['status_pegawai'] = 'PPPK';
        } elseif (str_contains(strtoupper($status), 'CPNS')) {
            $record['status_pegawai'] = 'CPNS';
        } elseif (str_contains(strtoupper($status), 'PNS')) {
            $record['status_pegawai'] = 'PNS';
        }

        // Validate jenis_kelamin
        $jk = trim((string)($record['jenis_kelamin'] ?? ''));
        if (str_starts_with(strtolower($jk), 'l')) {
            $record['jenis_kelamin'] = 'Laki-laki';
        } elseif (str_starts_with(strtolower($jk), 'p')) {
            $record['jenis_kelamin'] = 'Perempuan';
        }

        return $record;
    }

    private function saveSummary($periode, $category, $data)
    {
        StatisticSummary::updateOrCreate(
            ['periode' => $periode, 'category' => $category],
            ['data' => json_encode($data)]
        );
    }
}
