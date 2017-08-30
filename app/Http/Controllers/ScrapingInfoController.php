<?php

namespace App\Http\Controllers;

use Gidlov\Copycat\Copycat;
use Illuminate\Http\Request;

class ScrapingInfoController extends Controller
{
    public function index()
    {
//     $info = file_get_contents('https://www.norwegian.com/uk/booking/flight-tickets/select-flight/?D_City=OSL&A_City=RIX&TripType=1&D_Day=01&D_Month=201710&D_SelectedDay=01&R_Day=01&R_Month=201710&R_SelectedDay=01&IncludeTransit=false&AgreementCodeFK=-1&CurrencyCode=GBP&rnd=90232&processid=49841');

//        $cc = new Copycat;
//        $cc->setCURL(array(
//            CURLOPT_RETURNTRANSFER => 1,
//            CURLOPT_CONNECTTIMEOUT => 5,
//            CURLOPT_HTTPHEADER, "Content-Type: text/html; charset=iso-8859-1",
//            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17',
//        ));
//
//        for ($day = 1; $day < 31; $day++) {
//
//            $cc->match(array(
//                'date' => '!<td nowrap="nowrap" class="layoutcell" align="right">&nbsp;(.*?)<\/td>!',
//                'departure' => '!<td class="depdest" title="Flight DY1072"><div class="content emphasize">(.*?)<\/div><\/td>!',
//                'arrival' => '!<td class="arrdest"><div class="content emphasize">(.*?)<\/div><\/td>!',
//                'Details' => '!<td class="duration"><div class="content">Duration:(.*?)<\/div><\/td>!'))
//                ->matchAll(array(
//                    'price' => '/title="GBP">(.*?)</ms',
//                ))->URLs('https://www.norwegian.com/uk/booking/flight-tickets/select-flight/?D_City=OSL&A_City=RIX&TripType=1&D_Day=' . $day . '&D_Month=201710&D_SelectedDay=01&R_Day=01&R_Month=201710&R_SelectedDay=01&IncludeTransit=false&AgreementCodeFK=-1&CurrencyCode=GBP&rnd=90232&processid=49841');
//
//            $info[] = $cc->get();
//        }
//
//        file_put_contents(storage_path('data.json'), json_encode($info));

        $info = json_decode(file_get_contents(storage_path('data.json')), true);

        dd($info);

        $info['data'] = $info;

        return view('info', $info);
    }

    public function alldata()
    {
//    $calendor = file_get_contents('https://www.norwegian.com/uk/booking/flight-tickets/farecalendar/?D_City=OSL&A_City=RIX&TripType=1&D_SelectedDay=01&D_Day=01&D_Month=201710&R_SelectedDay=01&R_Day=01&R_Month=201710&IncludeTransit=false&CurrencyCode=GBP&processid=8029');

        $calendor = new Copycat;
        $calendor->setCURL(array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER, "Content-Type: text/html; charset=iso-8859-1",
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17',
        ));

        $calendor->matchAll([
//            'dateNotfly' => '!<div class="fareCalDate">(.*?)<\/div>!',
            'price' => '!<div class="fareCalPrice">(.*?)<\/div>!',
        ])->URLs('https://www.norwegian.com/uk/booking/flight-tickets/farecalendar/?D_City=OSL&A_City=RIX&TripType=1&D_SelectedDay=29&D_Day=29&D_Month=201710&R_SelectedDay=01&R_Day=01&R_Month=201710&dFare=38&IncludeTransit=false&AgreementCodeFK=-1&CurrencyCode=EUR');

        $prices = $calendor->get();


        $pricesRound = $prices[0]['price'];

//        foreach ($pricesRound as $key => $value) {
//             $pricess = round($value);

//            dd(count($pricesRound));
//            dd(round($pricesRound[0]));
//            $dateNotFly = $prices[0]['dateNotfly'];


            for ($day = 1; $day < 31; $day++) {

                $pricesRound = round($prices[0]['price'][$day -1]);
//                dd($prices[0]['price'][$day - 1] == '&nbsp;');
                if ($prices[0]['price'][$day - 1] == '&nbsp;') {

                } else {
                    $info = new Copycat;
                    $info->setCURL(array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_CONNECTTIMEOUT => 5,
                        CURLOPT_HTTPHEADER, "Content-Type: text/html; charset=iso-8859-1",
                        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17',
                    ));

                    $info->match(array(
                        'date' => '!<td nowrap="nowrap" class="layoutcell" align="right">&nbsp;(.*?)<\/td>!',
                        'departure' => '!<td class="depdest" title="Flight DY1072"><div class="content emphasize">(.*?)<\/div><\/td>!',
                        'arrival' => '!<td class="arrdest"><div class="content emphasize">(.*?)<\/div><\/td>!',
                        'details' => '!<td class="duration"><div class="content">Duration:(.*?)<\/div><\/td>!',
                        'price' => '/title="EUR">(.*?)</ms',
//                        'tax' => '!<td class="rightcell emphasize" align="right" valign="bottom">(.*?)<\/td>!'))
                            'tax' => '/class="rightcell emphasize" align="right" valign="bottom">(.*?)</ms',))
                        ->URLs('https://www.norwegian.com/en/booking/flight-tickets/select-flight/?D_City=OSL&A_City=RIX&TripType=1&D_SelectedDay=' . $day . '&D_Day=' . $day . '&D_Month=201710&R_SelectedDay=' . $day . '&R_Day=01&R_Month=201710&dFare=' . $pricesRound . '&IncludeTransit=false&AgreementCodeFK=-1&CurrencyCode=EUR');

                    $info = $info->get();

                }
            }

            dd($info);


        }

//    }
}
