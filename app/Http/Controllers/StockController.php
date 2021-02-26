<?php

namespace App\Http\Controllers;

use App\Http\Traits\CallAPI;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    use CallAPI;

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
        $data = (array) $this->callSearchAPI($symbol);;
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
        $apiResponse = $this->callAPI($symbol);
        list($stockInformation, $message) = $this->getStockInformation($apiResponse);
        if($stockInformation){
            Stock::create($stockInformation);
        }
        return ['success'=> (bool)$stockInformation, 'data'=>$stockInformation, 'message' => $message];
    }
}
