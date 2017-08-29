<?php

namespace App\Http\Controllers;

use Gidlov\Copycat\Copycat;
use Illuminate\Http\Request;

class ScrapingInfoController extends Controller
{
    public function index()
    {
        $info = file_get_contents('https://www.norwegian.com/uk/booking/flight-tickets/select-flight/?D_City=OSL&A_City=RIX&TripType=1&D_Day=01&D_Month=201710&D_SelectedDay=01&R_Day=01&R_Month=201710&R_SelectedDay=01&IncludeTransit=false&AgreementCodeFK=-1&CurrencyCode=GBP&rnd=90232&processid=49841');
//        dd($info);

        $cc = new Copycat;
        $cc->setCURL(array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER, "Content-Type: text/html; charset=iso-8859-1",
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17',
        ));

        $cc->matchAll(array(
            'price' => '/title="GBP">(.*?)</ms',))->URLs('https://www.norwegian.com/uk/booking/flight-tickets/select-flight/?D_City=OSL&A_City=RIX&TripType=1&D_Day=01&D_Month=201710&D_SelectedDay=01&R_Day=01&R_Month=201710&R_SelectedDay=01&IncludeTransit=false&AgreementCodeFK=-1&CurrencyCode=GBP&rnd=90232&processid=49841');
        $info = $cc->get();
        $info['price'] = $info;

        return view('info',$info);
    }
}
