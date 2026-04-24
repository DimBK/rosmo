<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationStructure;
use Illuminate\Support\Facades\Storage;

class OrganizationStructureController extends Controller
{
    public function index()
    {
        $structures = OrganizationStructure::with('parent')->orderBy('sort_order')->get();
        return view('admin.organization_structures.index', compact('structures'));
    }

    public function create()
    {
        $allStructures = OrganizationStructure::orderBy('sort_order')->get();
        return view('admin.organization_structures.create', compact('allStructures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
            'official_name' => 'nullable|string|max:255',
            'echelon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:organization_structures,id',
            'sort_order' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('organization', 'public');
        }

        OrganizationStructure::create($data);

        return redirect()->route('admin.organization_structures.index')->with('success', 'Posisi berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $structure = OrganizationStructure::findOrFail($id);
        $allStructures = OrganizationStructure::where('id', '!=', $id)->orderBy('sort_order')->get();
        return view('admin.organization_structures.edit', compact('structure', 'allStructures'));
    }

    public function update(Request $request, string $id)
    {
        $structure = OrganizationStructure::findOrFail($id);

        $request->validate([
            'position_name' => 'required|string|max:255',
            'official_name' => 'nullable|string|max:255',
            'echelon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:organization_structures,id',
            'sort_order' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($structure->image) {
                Storage::disk('public')->delete($structure->image);
            }
            $data['image'] = $request->file('image')->store('organization', 'public');
        }

        $structure->update($data);

        return redirect()->route('admin.organization_structures.index')->with('success', 'Posisi berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $structure = OrganizationStructure::findOrFail($id);
        
        if ($structure->image) {
            Storage::disk('public')->delete($structure->image);
        }
        
        $structure->delete();

        return redirect()->route('admin.organization_structures.index')->with('success', 'Posisi berhasil dihapus');
    }

    public function export()
    {
        $structures = OrganizationStructure::orderBy('sort_order')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Output headers
        $sheet->setCellValue('A1', 'ID')->getColumnDimension('A')->setVisible(true);
        $sheet->setCellValue('B1', 'Satker / Jabatan')->getColumnDimension('B')->setAutoSize(true);
        $sheet->setCellValue('C1', 'Eselon / Tingkat')->getColumnDimension('C')->setAutoSize(true);
        $sheet->setCellValue('D1', 'Nama Pejabat')->getColumnDimension('D')->setAutoSize(true);

        // Styling headers
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($structures as $structure) {
            $sheet->setCellValue('A' . $row, $structure->id);
            $sheet->setCellValue('B' . $row, $structure->position_name);
            $sheet->setCellValue('C' . $row, $structure->echelon ?? '-');
            $sheet->setCellValue('D' . $row, $structure->official_name ?? '');
            
            // To prevent Excel treating IDs as formulas or numbers without zero paddings
            $sheet->getStyle('A' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Template_Struktur_Organisasi_' . date('Ymd_His') . '.xlsx';

        // Redirect output to a client's web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            
            $updated = 0;
            
            foreach ($sheetData as $index => $row) {
                // Skip header (first row)
                if ($index === 1 || empty($row['A'])) {
                    continue;
                }

                $id = $row['A'];
                $namaPejabat = trim($row['D'] ?? '');
                
                $structure = OrganizationStructure::find($id);
                if ($structure) {
                    $structure->official_name = empty($namaPejabat) ? null : $namaPejabat;
                    $structure->save();
                    $updated++;
                }
            }

            return redirect()->back()->with('success', "Import berhasil! {$updated} data pejabat diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }
}
