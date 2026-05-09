<?php

namespace App\Exports;

use App\Models\Subsection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class TemplateSoalExport implements WithHeadings, WithEvents, WithStyles
{
    public $section;

    public function __construct($section = null)
    {
        $this->section = $section;
    }

    // 1. Membuat Judul Kolom (Sesuai ERD Penuh)
    public function headings(): array
    {
        return [
            'Subsection_ID',
            'Group_Code',
            'Group_Title',
            'Group_Instruction',
            'Group_Type',
            'Group_Passage',
            'Group_Image',
            'Group_Audio',
            'Group_Order',
            'Question_Type',
            'Question_Text',
            'Question_Image',
            'Question_Audio',
            'Points',
            'Question_Order',
            'Opt_A',
            'Opt_B',
            'Opt_C',
            'Opt_D',
            'Correct_Answer'
        ];
    }

    // 2. Format Judul Kolom
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF4F46E5']] // Warna Indigo
            ],
        ];
    }

    // 3. SIHIR DROPDOWN
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // --- A. DATA SUBSECTION DI KOLOM TERSEMBUNYI (Pindah ke kolom AA agar tidak tertabrak) ---
                $query = Subsection::with('section.exam');
                if ($this->section) {
                    $query->where('section_id', $this->section->id);
                }
                $subsections = $query->get();
                
                $rowAA = 1;

                foreach ($subsections as $sub) {
                    $examName = $sub->section->exam->title ?? 'Ujian';
                    $sectionName = $sub->section->title ?? 'Sesi';
                    $teksDropdown = "[{$sub->id}] {$examName} - {$sectionName} - {$sub->title}";

                    $sheet->setCellValue("AA{$rowAA}", $teksDropdown);
                    $rowAA++;
                }

                $sheet->getColumnDimension('AA')->setVisible(false);
                $batasAA = ($rowAA > 1) ? ($rowAA - 1) : 1;

                // --- B. APLIKASIKAN DROPDOWN KE 1000 BARIS KE BAWAH ---
                for ($i = 2; $i <= 1000; $i++) {

                    // 1. Dropdown Subsection_ID (Kolom A)
                    $valSubsection = $sheet->getCell("A{$i}")->getDataValidation();
                    $valSubsection->setType(DataValidation::TYPE_LIST);
                    $valSubsection->setErrorStyle(DataValidation::STYLE_STOP);
                    $valSubsection->setAllowBlank(true);
                    $valSubsection->setShowDropDown(true);
                    $valSubsection->setFormula1('=$AA$1:$AA$' . $batasAA);

                    // 2. Dropdown Group_Type (Kolom E) -> Penanda Layout UI
                    $valGroupType = $sheet->getCell("E{$i}")->getDataValidation();
                    $valGroupType->setType(DataValidation::TYPE_LIST);
                    $valGroupType->setErrorStyle(DataValidation::STYLE_STOP);
                    $valGroupType->setAllowBlank(true);
                    $valGroupType->setShowDropDown(true);
                    // Masukkan 3 opsi layout emas kita:
                    $valGroupType->setFormula1('"split_screen,single_column,standalone"');

                    // 3. Dropdown Question_Type (Kolom J)
                    $valQType = $sheet->getCell("J{$i}")->getDataValidation();
                    $valQType->setType(DataValidation::TYPE_LIST);
                    $valQType->setErrorStyle(DataValidation::STYLE_STOP);
                    $valQType->setAllowBlank(true);
                    $valQType->setShowDropDown(true);
                    $valQType->setFormula1('"multiple_choice,short_answer,essay,audio_record"');

                    // 4. Dropdown Correct_Answer (Kolom T)
                    $valAns = $sheet->getCell("T{$i}")->getDataValidation();
                    $valAns->setType(DataValidation::TYPE_LIST);
                    $valAns->setErrorStyle(DataValidation::STYLE_STOP);
                    $valAns->setAllowBlank(true);
                    $valAns->setShowDropDown(true);
                    $valAns->setFormula1('"A,B,C,D"');
                }

                // Lebarkan kolom otomatis agar rapi
                foreach (range('A', 'T') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
