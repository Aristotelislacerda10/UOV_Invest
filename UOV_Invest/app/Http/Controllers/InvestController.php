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

        $ArrayTableCotacaoCrypto["datahora"]   = '2022-05-29 13:10:00';
        $ArrayTableCotacaoCrypto["open"]   = '0';
        $ArrayTableCotacaoCrypto["high"]   = '0';
        $ArrayTableCotacaoCrypto["low"]    = '0';
        $ArrayTableCotacaoCrypto["close"]  = '0';
        $ArrayTableCotacaoCrypto["volume"] = '0';

      //  dd($ArrayTableCotacaoCrypto);

        return view('invest.ConsultaBolsa',compact('ArrayTableCotacaoCrypto'));
      
    }

    public function RealizaConsulta(Request $request){
        // Ações da bolsa
        // $response = Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');
        
            $TextoRequisicao = 'https://www.alphavantage.co/query?function=CRYPTO_INTRADAY&symbol=' . $request->get('symbol') . '&market=BRL&interval=5min&apikey=B45NKBK0LP76EMSH';
         $response = Http::withOptions(['verify' => false])->get($TextoRequisicao);

         $ObjectResponse = json_decode($response, true);

        // dd($ObjectResponse);

        $CabecalhoResponse = $ObjectResponse["Meta Data"];
        $CotacaoResponse = $ObjectResponse["Time Series Crypto (5min)"];

       // dd($CabecalhoResponse["3. Digital Currency Name"]);

        foreach ($CotacaoResponse as $CotacaoResponses) {
            $ArrayTableCotacaoCrypto["datahora"]   = key($CotacaoResponse);
            $ArrayTableCotacaoCrypto["open"]   = $CotacaoResponses["1. open"];
            $ArrayTableCotacaoCrypto["high"]   = $CotacaoResponses["2. high"];
            $ArrayTableCotacaoCrypto["low"]    = $CotacaoResponses["3. low"];
            $ArrayTableCotacaoCrypto["close"]  = $CotacaoResponses["4. close"];
            $ArrayTableCotacaoCrypto["volume"] = $CotacaoResponses["5. volume"];
           // dd($ArrayTableCotacaoCrypto);
     
        }

       //  dd($ObjectResponse["Meta Data"]);
          dd($CotacaoResponse);
          return view('invest.ConsultaBolsa',compact('ArrayTableCotacaoCrypto'));
        
      }
}
