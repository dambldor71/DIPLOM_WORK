<?php
declare(strict_types=1);

namespace App\Services\Search;

use Illuminate\Console\Application;
use phpQuery;
use function App\Http\Controllers\parser;

class SearchTenderService
{
    public function showTenderInformation($id)
    {
        require __DIR__ . '/phpQuery-onefile.php';

        if (str_contains($id, 'notice')) {
            $url = 'https://zakupki.gov.ru/epz/order/notice/notice223/common-info.html?' . $id;
        } else {
            $url = 'https://zakupki.gov.ru/epz/order/notice/ea20/view/common-info.html?' . $id;
        }
//        https://zakupki.gov.ru  /epz/order/notice/ezt20/view/common-info.html?regNumber=0316300001625000003
//        https://zakupki.gov.ru  /epz/order/notice/zk20/view/common-info.html?regNumber=0361300002125000006
        $file = $this->parser($url);
        $pq = phpQuery::newDocument($file);

        $oneTenderInfo = [
            'lawType' => explode(' ', preg_replace('/\s+/', ' ',
                trim(str_replace("\n", "", $pq->find('.text-truncate')->text() ?: $pq->find('.registry-entry__header-top__title')->text())))),
            'code' => $pq->find('.cardMainInfo__status .distancedText a')->text() ?: trim($pq->find('.registry-entry__header-mid__number a')->text()),
            'price' => trim($pq->find('.price .cost')->text()) ?: trim($pq->find('.price-block__value')->text()),
            'author' => $pq->find('.sectionMainInfo__body .cardMainInfo__section .cardMainInfo__content a')->text() ?: trim($pq->find('.registry-entry__body-value a')->text()),
            'authorLink' => $pq->find('.sectionMainInfo__body .cardMainInfo__section .cardMainInfo__content a')->attr('href') ?: trim($pq->find('.registry-entry__body-value a')->attr('href')),
            'status' => trim($pq->find('.cardMainInfo__status .cardMainInfo__state')->text() ?: $pq->find('.registry-entry__header-mid__title')->text()),
            'dates' => explode(' ', preg_replace('/\s+/', ' ',
                trim(str_replace("\n", "", $pq->find('.date .cardMainInfo__content')->text() ?: $pq->find('.data-block__value')->text())))),
            'placeName' =>  explode(' ', preg_replace('/\s+/', ' ',
                trim(str_replace("\n", "", $pq->find('.section__info a')->text() ?: $pq->find('.common-text__value a')->text()))))[0],
        ];

//        dd($oneTenderInfo);

        return view('search.tender', compact('oneTenderInfo'));
    }
    public function searchAllTenders()
    {
        $url = 'https://zakupki.gov.ru/epz/order/extendedsearch/results.html';
        require __DIR__ . '/phpQuery-onefile.php';

        $file = $this->parser($url);

        $pq = phpQuery::newDocument($file);

        $title = $pq->find('.registry-entry__header-mid__number a');
        $data = array();

        foreach ($title as $oneTitle) {
            $elem = pq($oneTitle);
            $data[] = [$elem->attr('href'), explode('?', $elem->attr('href'))[1]];
        }

        $tenderInfo = array();
        $tenderPath = 'https://zakupki.gov.ru';

        foreach ($data as $one) {
            $tenderUrl = $tenderPath . $one[0];
            $tenderPage = $this->parser($tenderUrl);
            $tenderPq = phpQuery::newDocument($tenderPage);

//            var_dump($tenderPq . "\n");
//            var_dump($tenderPq->find('.cardMainInfo__status .distancedText')->text() ?: trim($tenderPq->find('.registry-entry__header-mid__number')->text()));

            $oneTenderInfo = [
                'link' => $one[0],
                'request' => $one[1],
                'code' => $tenderPq->find('.cardMainInfo__status .distancedText a')->text() ?: trim($tenderPq->find('.registry-entry__header-mid__number a')->text()),
                'price' => trim($tenderPq->find('.price .cost')->text()) ?: trim($tenderPq->find('.price-block__value')->text()),
                'author' => $tenderPq->find('.sectionMainInfo__body .cardMainInfo__section .cardMainInfo__content a')->text() ?: trim($tenderPq->find('.registry-entry__body-value a')->text()),
                'status' => trim($tenderPq->find('.cardMainInfo__status .cardMainInfo__state')->text()) ?: trim($tenderPq->find('.registry-entry__header-mid__title')->text()),
                'dates' => explode(' ', preg_replace('/\s+/', ' ',
                    trim(str_replace("\n", "", $tenderPq->find('.date .cardMainInfo__content')->text() ?: $tenderPq->find('.data-block__value')->text())))),
            ];
            $tenderInfo[] = $oneTenderInfo;
        }

        dd($tenderInfo);

        return view('search.catalog', compact('tenderInfo'));
    }

    public function parser($urlPage): bool|string
    {
        $ch = curl_init($urlPage);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
