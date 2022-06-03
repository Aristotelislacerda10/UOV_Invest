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
        $CabecalhoResponse["3. Digital Currency Name"]          = 'Nome moeda';
        $HoraCotacao      = 0;


      //  dd($ArrayTableCotacaoCrypto);

       return view('invest.ConsultaBolsa',compact('CotacaoResponse','ArrayValorFechado','ArrayMaisAlto',
                    'ArrayMaisBaixo', 'CabecalhoResponse','HoraCotacao'));
      
    }

    public function RealizaConsulta(Request $request){
        // Ações da bolsa
        // $response = Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');
        
         $TextoRequisicao = 'https://www.alphavantage.co/query?function=CRYPTO_INTRADAY&symbol=' . $request->get('symbol') . '&market=BRL&interval=30min&apikey=B45NKBK0LP76EMSH';
         $TextoRequisicaoTotais = 'https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=' . $request->get('symbol') . '&to_currency=BRL&apikey=B45NKBK0LP76EMSH';
         
         $response = Http::withOptions(['verify' => false])->get($TextoRequisicao);
         $responseTotais = Http::withOptions(['verify' => false])->get($TextoRequisicaoTotais);

         $ObjectResponse       = json_decode($response, true);
         $ObjectResponseTotais = json_decode($responseTotais, true);
         $ObjectResponseTotais = $ObjectResponseTotais["Realtime Currency Exchange Rate"];

       //  dd($ObjectResponseTotais);

        $CabecalhoResponse = $ObjectResponse["Meta Data"];
        $CotacaoResponse   = $ObjectResponse["Time Series Crypto (30min)"];

       // dd($CabecalhoResponse["3. Digital Currency Name"]);

         $horaMovimento = date("H:i"); 
         $contador      = 0;
        foreach ($CotacaoResponse as $CotacaoResponses) {
           $contador             = $contador + 30;
           $ArrayValorFechado[]  = $CotacaoResponses["4. close"];
           $HoraCotacao[]        = date('H:i', strtotime("-".$contador. " minutes",strtotime($horaMovimento)));
           $ArrayMaisAlto[]      = $CotacaoResponses["2. high"];
           $ArrayMaisBaixo[]     = $CotacaoResponses["3. low"];   
        }
        //dd(implode(',',$HoraCotacao));
          return view('invest.ConsultaBolsa',compact('CotacaoResponse','ArrayValorFechado',
                      'ArrayMaisAlto','ArrayMaisBaixo','CabecalhoResponse','HoraCotacao','ObjectResponseTotais'));
        
      }
}
