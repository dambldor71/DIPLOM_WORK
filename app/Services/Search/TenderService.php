<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Builder;

class TenderService
{
    public function showOne($id)
    {
        $categories = Category::query()->get()->toArray();
        $filters = $this->selectFilter()->get()->toArray();

        $oneTenderInfo = Tender::select('id', 'tender_code', 'price', 'link', 'description',
            'customer', 'law', 'purchase_stage', 'type_of_select', 'start_date', 'update_date', 'end_date', 'source_link')->where('id', $id)->get()->toArray()[0];
        $tenderFilters = $this->selectFilter()
            ->whereIn('fid', [$oneTenderInfo['law'], $oneTenderInfo['purchase_stage'], $oneTenderInfo['type_of_select']])
            ->pluck('name')->toArray();

        return view('search.tender', compact('oneTenderInfo', 'tenderFilters', 'categories', 'filters'));
    }

    public function showAll($tenderInformatrion, $searchBox, $catalogType = 'all')
    {
        $tenderInfo = $tenderInformatrion;

        if (!empty($searchBox)) {
            $lawArr = [];
            $stageArr = [];
            $typeArr = [];
            foreach ($searchBox as $key => $searchElement) {
                if ($key === 'searchString' || $key === 'page' || $key === 'price') {
                    continue;
                }

                $elemArr = explode('-', $searchElement);

                if ($elemArr[0] === '1') {
                    $lawArr[] = $elemArr[1];
                } elseif ($elemArr[0] === '2') {
                    $stageArr[] = $elemArr[1];
                } else {
                    $typeArr[] = $elemArr[1];
                }
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
            ->select('name')
            ->whereIn('fid', array_slice(array_keys($searchBox), 2))
            ->get()
            ->toArray();

        $categories = Category::query()->get()->sortBy('cid')->toArray();
        $filters = $this->selectFilter()->get()->sortBy('fid')->toArray();

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
