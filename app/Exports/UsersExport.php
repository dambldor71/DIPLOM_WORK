<?php

namespace App\Exports;

use App\Models\Tender;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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
        return Tender::select('tenders.id', 'tender_code', 'p.name', 'ws.name as stageName',
            'filters.name as lawName', 'fp.name as purchaseName', 'fty.name as typeName', 'price', 'customer',
            'tenders.description', 'start_date', 'update_date', 'end_date', 'link', 'source_link')
            ->rightJoin('favourite_tenders as ft' , 'ft.tender_id', '=', 'tenders.id')
            ->leftJoin('filters', 'tenders.law', '=', 'filters.fid')
            ->leftJoin('filters as fp', 'tenders.purchase_stage', '=', 'fp.fid')
            ->leftJoin('filters as fty', 'tenders.type_of_select', '=', 'fty.fid')
            ->where('ft.user_id', Auth::id())
            ->leftJoin('priority_tender as pt', 'pt.tender_id', '=', 'ft.id')
            ->leftJoin('priority as p', 'p.id', '=', 'pt.priority_id')
            ->leftJoin('work_stage_tenders as wst', 'wst.favourite_id', '=', 'ft.id')
            ->leftJoin('work_stage as ws', 'ws.id', '=', 'wst.stage_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Код тендера',
            'Приоритет',
            'Этап работы над тендером',
            'Закон',
            'Этап тендера',
            'Способ определения поставщика',
            'Цена',
            'Заказчик',
            'Описание',
            'Дата начала',
            'Последнее обновление',
            'Дата окончания',
            'Ссылка на эл.площадку',
            'Ссылка на первоисточник',
        ];
    }

    public function styles(Worksheet $sheet)
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
