<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BaseClient;

class PulperController extends Controller
{
    public function __construct(){
        
    }
    
    public function index(Request $request){
        
        return view("pulper.index");
    }
    
    public function list(){
        
        $response = [
            "code"      => 400,
            "message"   => "Failed to complete request",
            "data"      => []
        ];
        
        
        try{
            $url = env('COUCHDB_URL');
            $client = new BaseClient();
            
            $getCookie = $client->loginCouchDB($url."/_session");
            $headerParams = [
                "Cookie" => $getCookie,
            ];
            $params = [];
            
            $response["code"] = 200;
            $response["message"] = "Success";
            $response["data"] = $client->callApi($url."/varion_pulper/_all_docs?include_docs=true", $headerParams, $params, "GET");
        } catch(\Exception $e){
            
        }
        
        return response()->json($response);
    }
    
    public function location(Request $request){
        
        $response = [
            "code"      => 400,
            "message"   => "Failed to complete request",
            "data"      => []
        ];
        
        
        try{
            $url = env('COUCHDB_URL');
            $endpoint = "/varion_pulper_location/_find";
            $isByParameter = false;
            
            $client = new BaseClient();
            
            $getCookie = $client->loginCouchDB($url."/_session");
            $headerParams = [
                "Cookie" => $getCookie,
            ];
            
            $params = [
                "selector" => []
            ];
            
            if($request->has("location") && ($request->input("location") !== null) && (strlen($request->input("location")) > 0)){
                $params["selector"]["Name"] = [ '$regex' => $request->input("location").".*" ];
                $isByParameter = true;
            }

            if($request->has("latitude") && ($request->input("latitude") !== null) && (strlen($request->input("latitude")) > 0)){
                $params["selector"]["Latitude"] = [ '$regex' => $request->input("latitude").".*" ];
                $isByParameter = true;
            }
            
            if($request->has("longitude") && ($request->input("longitude") !== null) && (strlen($request->input("longitude")) > 0)){
                $params["selector"]["Longitude"] = [ '$regex' => $request->input("longitude").".*" ];
                $isByParameter = true;
            }
            
            if(!$isByParameter){
                $params["selector"]["_id"] = [ '$gt' => null ];
                
                $count = $client->callApi($url."/varion_pulper_location/_all_docs?limit=0", $headerParams, [], "GET");
                $params["limit"] = $count["total_rows"];
            }
            
            $response["code"] = 200;
            $response["message"] = "Success";
            $response["data"] = $client->callApi($url.$endpoint, $headerParams, $params);
        } catch(\Exception $e){
            
        }
        
        return response()->json($response);
    }
    
    public function transaction(Request $request){
        
        $response = [
            "code"      => 400,
            "message"   => "Failed to complete request",
            "data"      => []
        ];
        
        
        try{
            $url = env('COUCHDB_URL');
            $endpoint = "/varion_pulper_to_huller/_find";
            $isByParameter = false;
            $client = new BaseClient();
            
            $getCookie = $client->loginCouchDB($url."/_session");
            $headerParams = [
                "Cookie" => $getCookie,
            ];
            
            $params = [
                "selector" => []
            ];
            
            $strName = "name";
            if($request->has("$strName") && ($request->input("$strName") !== null) && (strlen($request->input("$strName")) > 0)){
                $params["selector"]["pulperName"] = [ '$regex' => $request->input("name").".*" ];
                $isByParameter = true;
            }
            
            $strId = "id";
            if($request->has("$strId") && ($request->input("$strId") !== null) && (strlen($request->input("$strId")) > 0)){
                $params["selector"]["pulperID"] = [ '$regex' => $request->input("$strId").".*" ];
                $isByParameter = true;
            }
            
            $strLocation = "location";
            if($request->has("$strLocation") && ($request->input("$strLocation") !== null) && (strlen($request->input("$strLocation")) > 0)){
                $params["selector"]["Location"] = [ '$regex' => $request->input("$strLocation").".*" ];
                $isByParameter = true;
            }
            
            $strBatchNumber = "batchNumer";
            if($request->has("$strBatchNumber") && ($request->input("$strBatchNumber") !== null) && (strlen($request->input("$strBatchNumber")) > 0)){
                $params["selector"]["BatchNumber"] = [ '$regex' => $request->input("$strName").".*" ];
                $isByParameter = true;
            }
            
            $strPoNumber = "poNumber";
            if($request->has("$strPoNumber") && ($request->input("$strPoNumber") !== null) && (strlen($request->input("$strPoNumber")) > 0)){
                $params["selector"]["PoNumber"] = [ '$regex' => $request->input("$strPoNumber").".*" ];
                $isByParameter = true;
            }
            
            $strReceiptNumber = "receiptNumber";
            if($request->has("$strReceiptNumber") && ($request->input("$strReceiptNumber") !== null) && (strlen($request->input("$strReceiptNumber")) > 0)){
                $params["selector"]["ReceiptNo"] = [ '$regex' => $request->input("$strReceiptNumber").".*" ];
                $isByParameter = true;
            }
            
            if(!$isByParameter){
                $params["selector"]["_id"] = [ '$gt' => null ];
                
                $count = $client->callApi($url."/varion_pulper_to_huller/_all_docs?limit=0", $headerParams, [], "GET");
                $params["limit"] = $count["total_rows"];
            }
            
            $response["code"] = 200;
            $response["message"] = "Success";
            $response["data"] = $client->callApi($url.$endpoint, $headerParams, $params);
        } catch(\Exception $e){
            
        }
        
        return response()->json($response);
    }
}
