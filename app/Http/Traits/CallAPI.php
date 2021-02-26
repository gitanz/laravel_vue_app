<?php


namespace App\Http\Traits;


trait CallAPI
{

    protected function callAPI($symbol){
        $params = [
            "function" => "GLOBAL_QUOTE",
            "symbol" => $symbol,
            "apikey" => env("ALPHA_VANTAGE_API_KEY")
        ];
        $queryString = http_build_query($params);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, "https://www.alphavantage.co/query?$queryString");
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curlHandle);
        return (array) json_decode($data);
    }

    protected function callSearchAPI($symbol){
        $params = [
            "function" => "SYMBOL_SEARCH",
            "keywords" => $symbol,
            "apikey" => env("ALPHA_VANTAGE_API_KEY")
        ];
        $queryString = http_build_query($params);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, "https://www.alphavantage.co/query?$queryString");
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curlHandle);
        return json_decode($data);
    }

    protected function formatInformation($response){
        $response = (array)$response;
        return [
            "symbol"  => $response["01. symbol"]?: null,
            "open"  => $response["02. open"]?: null,
            "high"  => $response["03. high"]?: null,
            "low" => $response["04. low"]?: null,
            "price" => $response["05. price"]?: null,
            "volume" => $response["06. volume"]?: null,
            "latest_trading_day" => $response["07. latest trading day"]?: null,
            "previous_close" => $response["08. previous close"]?: null,
            "change" => $response["09. change"]?: null,
            "change_percent"  => $response["10. change percent"]?: null,
        ];
    }

    protected function isValidResponse($response){
        return isset($response["Global Quote"]);
    }

    protected  function getGlobalQuote($response){
        return $this->isValidResponse($response) ? (array)$response["Global Quote"] : false;
    }

    protected function getResponseErrorMessage($response){
        return isset($response["Note"]) ? $response["Note"] :  "Something unexpected occurred";
    }

    protected function getStockInformation($response){
        $response = (array) $response;

        if(!$this->isValidResponse($response)){
            $stockInformation = false;
            $message = $this->getResponseErrorMessage($response);
        }
        else{
            $information = $this->getGlobalQuote($response);
            $stockInformation = $this->formatInformation($information);
            $message = 'Succesfully fetched stock information';
        }
        return [$stockInformation, $message];
    }
}
