<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScrapingInfoController extends Controller
{
    public function index()
    {
        $info = file_get_contents('https://www.norwegian.com/uk/booking/flight-tickets/select-flight/
        ?D_City=OSL
        &A_City=RIX
        &TripType=1
        &D_Day=01
        &D_Month=201710
        &D_SelectedDay=01
        &R_Day=01
        &R_Month=201710
        &R_SelectedDay=01
        &IncludeTransit=false
        &AgreementCodeFK=-1
        &CurrencyCode=GBP
        &rnd=90232
        &processid=49841');
        dd($info);
        return view('info',$info);
    }
}
