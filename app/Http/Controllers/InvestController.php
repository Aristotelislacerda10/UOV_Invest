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

        $CotacaoResponse["1. open"]   = 0;
        $CotacaoResponse["2. high"]   = 0;
        $CotacaoResponse["3. low"]    = 0;
        $CotacaoResponse["4. close"]  = 0;
        $CotacaoResponse["5. volume"] = 0;
        $ArrayValorFechado[]          = 0;
        $ArrayMaisAlto[]              = 0;
        $ArrayMaisBaixo[]             = 0;

      //  dd($ArrayTableCotacaoCrypto);

       return view('invest.ConsultaBolsa',compact('CotacaoResponse','ArrayValorFechado','ArrayMaisAlto','ArrayMaisBaixo'));
      
    }

    public function RealizaConsulta(Request $request){
        // Ações da bolsa
        // $response = Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');
        
            $TextoRequisicao = 'https://www.alphavantage.co/query?function=CRYPTO_INTRADAY&symbol=' . $request->get('symbol') . '&market=BRL&interval=5min&apikey=B45NKBK0LP76EMSH';
         $response = Http::withOptions(['verify' => false])->get($TextoRequisicao);

         $ObjectResponse = json_decode($response, true);

        // dd($ObjectResponse);

        $CabecalhoResponse = $ObjectResponse["Meta Data"];
        $CotacaoResponse   = $ObjectResponse["Time Series Crypto (5min)"];

       // dd($CabecalhoResponse["3. Digital Currency Name"]);

        foreach ($CotacaoResponse as $CotacaoResponses) {
           $ArrayValorFechado[]  = $CotacaoResponses["4. close"];
           $ArrayMaisAlto[]     = $CotacaoResponses["2. high"];
           $ArrayMaisBaixo[]     = $CotacaoResponses["3. low"];
     
        }
       //  dd($ObjectResponse["Meta Data"]);
       //   dd(($CotacaoResponse));
          return view('invest.ConsultaBolsa',compact('CotacaoResponse','ArrayValorFechado','ArrayMaisAlto','ArrayMaisBaixo'));
        
      }
}
