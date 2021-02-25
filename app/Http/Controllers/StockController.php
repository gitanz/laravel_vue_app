<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockCollection;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function __construct(){}

    public function index(Request $request){
        $offset = $request->input("offset");
        $limit = $request->input("limit");

        return
            [
                "success" => true,
                "offset" => $offset,
                "limit" => $limit,
                "data" =>DB::table('stocks')->get(),
                "count" => DB::table('stocks')->count()
            ];
    }

    public function searchSymbol(Request $request){
        $symbol = $request->input('stock-symbol');
        $params = [
            "function" => "SYMBOL_SEARCH",
            "keywords" => $symbol,
            "apikey" => env("ALPHA_VANTAGE_API_KEY")
        ];
        $data = (array) $this->callAPI($params);

        $bestMatches = isset($data["bestMatches"])?$data["bestMatches"]:[];
        $searchOutput = [];
        foreach($bestMatches as $bestMatch){
            $bestMatch = (array)$bestMatch;
            $searchOutput[] = ['symbol'=>$bestMatch['1. symbol'], 'name' => $bestMatch['2. name']];
        }
        return $searchOutput;
    }

    public function getStockQuote(Request $request){
        $symbol = $request->input('stock-symbol');
        $params = [
            "function" => "GLOBAL_QUOTE",
            "symbol" => $symbol,
            "apikey" => env("ALPHA_VANTAGE_API_KEY")
        ];
        $apiResponse = (array) $this->callAPI($params);
        if(!isset($apiResponse["Global Quote"])){
            try{
                $errorMsg = $apiResponse["Note"];
                return ['success'=> false, 'message' => $errorMsg];
            }catch (\Exception $exception){
                return ['success'=> false, 'message' => "Contact administrator"];
            }
        }
        $information = (array)($apiResponse["Global Quote"]);

        $stock = [
            "symbol"  => $information["01. symbol"]?: null,
            "open"  => $information["02. open"]?: null,
            "high"  => $information["03. high"]?: null,
            "low" => $information["04. low"]?: null,
            "price" => $information["05. price"]?: null,
            "volume" => $information["06. volume"]?: null,
            "latest_trading_day" => $information["07. latest trading day"]?: null,
            "previous_close" => $information["08. previous close"]?: null,
            "change" => $information["09. change"]?: null,
            "change_percent"  => $information["10. change percent"]?: null,
        ];

        Stock::create($stock);

        return ["success" => true, "data"=> $stock];

    }

    private function callAPI($params){
        $queryString = http_build_query($params);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, "https://www.alphavantage.co/query?$queryString");
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curlHandle);
        return json_decode($data);
    }
}
