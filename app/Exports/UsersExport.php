<?php

namespace App\Exports;

use App\Models\Tender;
use App\Models\WorkStageTendersModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $userId;
    protected $uploadKind;
    protected  $needField;

    public function __construct($userId, $uploadKind, $needField)
    {
        $this->userId = $userId;
        $this->uploadKind = $uploadKind;
        $this->needField = $needField;
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
        $range = 'A1:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'];

        return [
            1 => ['font' => ['bold' => true]], // Стилизация первой строки (заголовки)
            $range => [
                'font' => ['size' => 11, 'name' => 'Times New Roman'], // Пример стилизации
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true], // Пример стилизации
            ],
        ];
    }
}
