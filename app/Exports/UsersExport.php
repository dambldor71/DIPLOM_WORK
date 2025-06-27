<?php

namespace App\Exports;

use App\Models\Tender;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class UsersExport implements FromCollection, WithCustomStartCell, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $userId;
    protected $uploadKind;
    protected  $needField;
    protected $mainTitle;

    public function __construct($userId, $uploadKind, $needField, $mainTitle = null)
    {
        $this->userId = $userId;
        $this->uploadKind = $uploadKind;
        $this->needField = $needField;
        $this->mainTitle = 'Отчёт по избранным тендерам';
    }

    /**
     * Указываем, с какой ячейки начинать запись данных (после шапки)
     */
    public function startCell(): string
    {
        return 'A5';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tenders = Tender::select($this->needField)
            ->rightJoin('favourite_tenders as ft' , 'ft.tender_id', '=', 'tenders.id')
            ->leftJoin('filters', 'tenders.law', '=', 'filters.fid')
            ->leftJoin('filters as fp', 'tenders.purchase_stage', '=', 'fp.fid')
            ->leftJoin('filters as fty', 'tenders.type_of_select', '=', 'fty.fid')
            ->where('ft.user_id', Auth::id())
            ->leftJoin('priority_tender as pt', 'pt.tender_id', '=', 'ft.id')
            ->leftJoin('priority as p', 'p.id', '=', 'pt.priority_id');

        if ($this->uploadKind === 'only-my') {
            $tenders = $tenders
                ->join('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
                ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id');;
        } elseif ($this->uploadKind === 'only-watch') {
            $tenders = $tenders
                ->leftJoin('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
                ->whereNotIn('ft.id', function ($query) {
                    $query
                        ->select('favourite_id')
                        ->from('work_stage_tenders');
                })
                ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id');
        } else {
            $tenders = $tenders
                ->leftJoin('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
                ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id');
        }

//        dd($tenders->get());
        return $tenders->get();
    }

    public function headings(): array
    {
        return array_keys($this->needField);
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRowAndColumn = $sheet->getHighestRowAndColumn();
        $range = 'A5:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'];

        return [
            1 => ['font' => ['name' => 'Times New Roman']],
            'A3:D3' => ['font' => ['name' => 'Times New Roman']],
            5 => ['font' => ['bold' => true]], // Стилизация первой строки (заголовки)
            $range => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'], // Цвет границы (черный в данном случае)
                    ],
                ],
                'font' => ['size' => 11, 'name' => 'Times New Roman'], // Пример стилизации
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true], // Пример стилизации
            ],
        ];
    }

    /**
     * @return array
     */
    public function writerProperties(): array
    {
        return [
            'orientation' => PageSetup::ORIENTATION_LANDSCAPE, // Для альбомной ориентации
            'paperSize'   => PageSetup::PAPERSIZE_A4,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                $highestRowAndColumn = $sheet->getHighestRowAndColumn();
                $sheet->getDelegate()->getDefaultColumnDimension()->setAutoSize(true);
                $sheet->mergeCells('A1:' . $highestRowAndColumn['column'] . 2);
                $sheet->mergeCells('A3:B3');
                $sheet->mergeCells('C3:D3');
                $sheet->mergeCells('A' . $highestRowAndColumn['row'] + 2 . ':' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'] + 2);
                // Записываем основной заголовок в объединенную ячейку
                $sheet->setCellValue('A1', $this->mainTitle);
                $sheet->setCellValue('A3', 'Дата: ' . date('d.m.Y'));
                $sheet->setCellValue('C3', 'ООО "Инженерный центр Пумори"');
                $sheet->setCellValue('A' . $highestRowAndColumn['row'] + 2, 'Подпись:__________');

                // Стиль для основного заголовка
                $sheet->getStyle('A1')->getFont()->setSize(18)->setBold(true);
                $sheet->getStyle('A3')->getFont()->setSize(11)->setBold(true);
                $sheet->getStyle('C3')->getFont()->setSize(11)->setBold(true);
                $sheet->getStyle('A' . $highestRowAndColumn['row'] + 2)->getFont()->setName('Times New Roman')->setSize(11)->setBold(true);

                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A' . $highestRowAndColumn['row'] + 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);

                $highestRow = $sheet->getHighestRow() - 2;

                for ($header = 2; $header <= 5; $header++) {
                    $sheet->getRowDimension($header)->setRowHeight(25);
                }

                for ($row = 6; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(100);
                }
            },
        ];
    }
}
