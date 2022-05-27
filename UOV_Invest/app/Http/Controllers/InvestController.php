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
        return view('invest.ConsultaBolsa');
      
    }

    public function RealizaConsulta(Request $request){
        // Ações da bolsa
        // $response = Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');
        
            $TextoRequisicao = 'https://www.alphavantage.co/query?function=CRYPTO_INTRADAY&symbol=' . $request->get('symbol') . '&market=BRL&interval=5min&apikey=B45NKBK0LP76EMSH';
         $response = Http::withOptions(['verify' => false])->get($TextoRequisicao);
         dd($response->json());
         // dd($response->body());
          return view('invest.ConsultaBolsa');
        
      }
}
