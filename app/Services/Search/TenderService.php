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
//        dd($searchBox);
//        dd($tenderInformatrion->get()->toArray(), $searchBox);
        $usedFiltersPart = [];
        $usedFiltersIds = [];

        if (!empty($searchBox)) {
            $lawArr = [];
            $stageArr = [];
            $typeArr = [];

            foreach ($searchBox as $key => $searchElement) {
//                dd($searchBox);
                $notNums = ['searchString', 'page', 'min-price', 'max-price', 'priority', 'stage'];
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

            if(!empty($searchBox['searchString'])) {
                $tenderInfo = $tenderInfo->whereLike('description', '%' . $searchBox['searchString'] . '%');
                $usedFiltersPart['searchString'] = $searchBox['searchString'];
            }
            if (!empty($lawArr)) {
                $tenderInfo = $tenderInfo->whereIn('law', $lawArr);
            }
            if (!empty($stageArr)) {
                $tenderInfo = $tenderInfo->whereIn('purchase_stage', $stageArr);
            }
            if (!empty($typeArr)) {
                $tenderInfo = $tenderInfo->whereIn('type_of_select', $typeArr);
            }
            if (in_array('min-price', array_keys($searchBox))) {
                if ($searchBox['min-price'] === null) {
                    $searchBox['min-price'] = 0;
                }
                if ($searchBox['max-price'] === null) {
                    $searchBox['max-price'] = Tender::pluck('price')->max();
                }
                $tenderInfo = $tenderInfo->where('price', '>', (float)$searchBox['min-price'])->where('price', '<', (float)$searchBox['max-price']);
                $usedFiltersPart['min-price'] = $searchBox['min-price'];
                $usedFiltersPart['max-price'] = $searchBox['max-price'];
            }

//            dd($searchBox);
            if ($catalogType !== 'all') {
                if (in_array('priority', array_keys($searchBox))) {
                    if ($searchBox['priority'] !== 'all') {
                        $tenderInfo = $tenderInfo->where('p.id', (int)$searchBox['priority']);
                        $usedFiltersPart[] = PriorityModel::where('id', (int)$searchBox['priority'])
                            ->pluck('name')
                            ->toArray()[0];
                    }
                }
                if (in_array('priority', array_keys($searchBox))) {
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
//            dd($tenderInfo, $tenderInfo->paginate(10), $tenderInfo->paginate(10)->withQueryString(), $tenderInfo->paginate(10)->withQueryString()->links());
            $tenderInfo = $tenderInfo->paginate(10)->withQueryString();
//            dd($tenderInfo);
        } else {
            $tenderInfo = $tenderInfo->get();
        }

//        dd($tenderInfo);
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
