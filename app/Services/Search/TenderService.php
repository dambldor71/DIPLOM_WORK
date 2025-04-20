<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Models\Category;
use App\Models\Filter;
use App\Models\PriorityModel;
use App\Models\Tender;
use App\Models\WorkStageModel;
use Illuminate\Database\Eloquent\Builder;

class TenderService
{
    public function showOne($tenderInfo, $request, $id, $catalogType = 'all')
    {
        $oneTenderInfo = $tenderInfo
            ->where('tenders.id', $id)
            ->get()
            ->toArray()[0];

        $categories = Category::query()->get()->toArray();
        $filters = $this->selectFilter()->get()->toArray();
        $title = $catalogType === 'all' ? '' : 'Избранное';

        $tenderFilters = $this->selectFilter()
            ->whereIn('fid', [$oneTenderInfo['law'], $oneTenderInfo['purchase_stage'], $oneTenderInfo['type_of_select']])
            ->pluck('name')->toArray();
        return view('search.tender', compact(
            'oneTenderInfo', 'tenderFilters', 'categories', 'filters', 'title'
        ));
    }

    public function showAll($tenderInformatrion, $searchBox, $catalogType = 'all')
    {
        $tenderInfo = $tenderInformatrion;
        $usedFiltersPart = [];
        $usedFiltersIds = [];
//        dd($tenderInfo->get()->toArray());

        if (!empty($searchBox)) {
            $lawArr = [];
            $stageArr = [];
            $typeArr = [];

            foreach ($searchBox as $key => $searchElement) {
                $notNums = ['searchString', 'page', 'min-price', 'max-price', 'priority',
                    'stage', 'stDate1', 'stDate2', 'finDate1', 'finDate2'];
                if (in_array($key, $notNums)) {
                    continue;
                }

                if ($searchElement === '1') {
                    $lawArr[] = str_replace('f', '', $key);
                } elseif ($searchElement === '2') {
                    $stageArr[] = str_replace('f', '', $key);
                } else {
                    $typeArr[] = str_replace('f', '', $key);
                }

                $usedFiltersIds[] = str_replace('f', '', $key);
            }

            // СТРОКА ПОИСКА
            if(!empty($searchBox['searchString'])) {
                $tenderInfo = $tenderInfo->whereLike('description', '%' . $searchBox['searchString'] . '%');
                $usedFiltersPart['searchString'] = $searchBox['searchString'];
            }

            // ДАТЫ
            if (!empty($searchBox['stDate1'])) {
                $tenderInfo = $tenderInfo->where('start_date', '>', $searchBox['stDate1']);
            }

            if (!empty($searchBox['stDate2'])) {
                $tenderInfo = $tenderInfo->where('start_date', '<', $searchBox['stDate2']);
            }

            if (!empty($searchBox['finDate1'])) {
                $tenderInfo = $tenderInfo->where('end_date', '>', $searchBox['finDate1']);
            }

            if (!empty($searchBox['finDate2'])) {
                $tenderInfo = $tenderInfo->where('end_date', '<', $searchBox['finDate2']);
            }

            // ЗАКОН
            if (!empty($lawArr)) {
                $tenderInfo = $tenderInfo->whereIn('law', $lawArr);
            }

            // ЭТАП
            if (!empty($stageArr)) {
                $tenderInfo = $tenderInfo->whereIn('purchase_stage', $stageArr);
            }

            // СПОСОБ ОПРЕДЕЛЕНИЯ ПОСТАВЩИКА
            if (!empty($typeArr)) {
                $tenderInfo = $tenderInfo->whereIn('type_of_select', $typeArr);
            }

            // ЦЕНА
            if (in_array('min-price', array_keys($searchBox))) {
                if ($searchBox['min-price'] === null) {
                    $searchBox['min-price'] = 0;
                }
                if ($searchBox['max-price'] === null) {
                    $searchBox['max-price'] = Tender::pluck('price')->max();
                }
                $tenderInfo = $tenderInfo->where('price', '>', (float)$searchBox['min-price'])->where('price', '<', (float)$searchBox['max-price']);
                $usedFiltersPart['price'] = $searchBox['min-price'] .  'руб. — ' . $searchBox['max-price'] . 'руб.';
            }

            // ДЛЯ ИЗБРАННОГО
            if ($catalogType !== 'all') {
                // ПРИОРИТЕТ
                if (in_array('priority', array_keys($searchBox))) {
                    if ($searchBox['priority'] !== 'all') {
                        $tenderInfo = $tenderInfo->where('p.id', (int)$searchBox['priority']);
                        $usedFiltersPart[] = PriorityModel::where('id', (int)$searchBox['priority'])
                            ->pluck('name')
                            ->toArray()[0];
                    }
                }

                // ЭТАП РАБОТ
                if (in_array('stage', array_keys($searchBox))) {
                    if ($searchBox['stage'] !== 'all') {
                        $tenderInfo = $tenderInfo->where('ws.id', (int)$searchBox['stage']);
                        $usedFiltersPart[] = WorkStageModel::where('id', (int)$searchBox['stage'])
                            ->pluck('name')
                            ->toArray()[0];
                    }
                }
            }
        }

        $links = 0;
        $allTendersNum = $catalogType === 'all'
                ? 'По результатам запроса найдено ' . $this->setRightDeclension($tenderInfo->count())
                : 'Всего в избранном ' . $this->setRightDeclension($tenderInfo->count());

        $title = $catalogType === 'all'
            ? 'Поиск тендеров'
            : 'Избранное';

        if (count($tenderInfo->get()) > 10) {
            $links += 1;
            $tenderInfo = $tenderInfo->paginate(10)->withQueryString();
        } else {
            $tenderInfo = $tenderInfo->get();
        }

        $usedFilters = Filter::query()
            ->whereIn('fid', $usedFiltersIds)
            ->pluck('name')
            ->toArray();
        $usedFilters = array_merge($usedFilters, $usedFiltersPart);

        $categories = Category::query()
            ->get()
            ->sortBy('cid')
            ->toArray();
        $filters = $this
            ->selectFilter()
            ->get()
            ->sortBy('fid')
            ->toArray();

//        dd($tenderInfo);
//        dd($usedFilters);
        return view('search.catalog',
            compact(
                'tenderInfo', 'categories', 'allTendersNum', 'filters', 'links', 'title', 'usedFilters'
            ));
    }

    /**
     * @return Builder
     */
    function selectFilter(): Builder
    {
        return Filter::query()
            ->leftJoin('filters_category', 'filters.fid', '=', 'filters_category.filter_id')
            ->leftJoin('categories', 'categories.cid', '=', 'filters_category.category_id')
            ->select('categories.cid', 'categories.code', 'filters.fid', 'filters.name');
    }

    function setRightDeclension($countTenders): string
    {
        if ($countTenders < 21 && $countTenders > 10) {
            return $countTenders . ' тендеров';
        } else {
            if ((int)str($countTenders)[-1] === 1) {
                return $countTenders . ' тендер';
            } elseif ((int)str($countTenders)[-1] < 5 && (int)str($countTenders)[-1] > 1) {
                return $countTenders . ' тендера';
            } else {
                return $countTenders . ' тендеров';
            }
        }
    }
}
