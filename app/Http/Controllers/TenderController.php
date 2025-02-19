<?php

namespace App\Http\Controllers;

use App\Models\myModel;

use App\Services\Search\SearchTenderService;
use Illuminate\Http\Request;
use phpQuery;

class TenderController extends Controller
{
    public function index(SearchTenderService $service, $id)
    {
        return $service->showOne($id);
    }
//        dd($id);
//        function parser($urlPage): bool|string
//        {
//            $ch = curl_init($urlPage);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_HEADER, false);
//            curl_setopt($ch, CURLOPT_TIMEOUT, 400);
//            $result = curl_exec($ch);
//            curl_close($ch);
//
//            return $result;
//        }
//        require __DIR__ . '/phpQuery-onefile.php';
//
//        $url = 'https://zakupki.gov.ru/epz/order/notice/ea20/view/common-info.html?regNumber=';
//
////        dd($id);
//        $file = parser($url . $id);
//
//        $pq = phpQuery::newDocument($file);
//
//        $title = $pq->find('.time-zone__value')->text();
//
//        $oneTenderInfo = [
//            'lawType' => explode(' ', preg_replace('/\s+/', ' ',
//                trim(str_replace("\n", "", $pq->find('.text-truncate')->text())))),
//            'code' => $pq->find('.cardMainInfo__status .distancedText a')->text() ?: trim($pq->find('.registry-entry__header-mid__number a')->text()),
//            'price' => trim($pq->find('.price .cost')->text()) ?: trim($pq->find('.price-block__value')->text()),
//            'author' => $pq->find('.sectionMainInfo__body .cardMainInfo__section .cardMainInfo__content a')->text() ?: trim($pq->find('.registry-entry__body-value a')->text()),
//            'authorLink' => $pq->find('.sectionMainInfo__body .cardMainInfo__section .cardMainInfo__content a')->attr('href'),
//            'status' => trim($pq->find('.cardMainInfo__status .cardMainInfo__state')->text()),
//            'dates' => explode(' ', preg_replace('/\s+/', ' ',
//                trim(str_replace("\n", "", $pq->find('.date .cardMainInfo__content')->text())))),
//            'placeName' =>  explode(' ', preg_replace('/\s+/', ' ',
//                trim(str_replace("\n", "", $pq->find('.section__info a')->text()))))[0],
//        ];
////        dd($oneTenderInfo);
//
//        return view('search.tender', compact('oneTenderInfo'));
//    }
}
