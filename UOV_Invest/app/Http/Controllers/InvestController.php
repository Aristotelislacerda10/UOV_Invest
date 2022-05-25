<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvestController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');
    // }
    /*----------------------------------------------------------------------------*/ 
    public function index(){

       // $response = Http::withBasicAuth('usuario','senha')->get('url');  
       
      // $response = Http::get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=B45NKBK0LP76EMSH'); 
     //  $response = request('GET', 'https://somewebsite.com', ['verify' => false]);

       $response = Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');

       // dd($response->json());
        dd($response->body());
      
    }
}
