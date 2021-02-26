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
                "data" =>DB::table('stocks')->orderBy('created_at', 'desc')->get(),
                "count" => DB::table('stocks')->count()
            ];
    }

    public function searchSymbol(Request $request){
        $symbol = $request->input('stock-symbol');
        $data = (array) $this->callSearchAPI($symbol);;
        $bestMatches = isset($data["bestMatches"])?$data["bestMatches"]:[];
        return array_map(array($this,'formatSearchInformation'), $bestMatches);
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
