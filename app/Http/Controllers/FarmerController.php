<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BaseClient;

class FarmerController extends Controller
{
    public function __construct(){
        
    }
    
    public function index(Request $request){
        return view("farmer.index");
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
            $params["selector"]["_id"] = [ '$gt' => null ];
            
            $response["code"] = 200;
            $response["message"] = "Success";
            $response["data"] = $client->callApi($url."/varion_farmer/_find", $headerParams, $params, "POST");
            
        } catch(\Exception $e){
            
        }
        
        return response()->json($response);
    }
    
    public function find(Request $request){
        
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
            
            $params = [
                "selector" => []
            ];
            
            $strName = "name";
            if($request->has("$strName") && ($request->input("$strName") !== null) && (strlen($request->input("$strName")) > 0)){
                $params["selector"]["FarmerName"] = [ '$regex' => $request->input("name").".*" ];
            }
            
            $strId = "id";
            if($request->has("$strId") && ($request->input("$strId") !== null) && (strlen($request->input("$strId")) > 0)){
                $params["selector"]["ID"] = [ '$regex' => $request->input("$strId").".*" ];
            }
            
            $strLocation = "location";
            if($request->has("$strLocation") && ($request->input("$strLocation") !== null) && (strlen($request->input("$strLocation")) > 0)){
                $params["selector"]["Location"] = [ '$regex' => $request->input("$strLocation").".*" ];
            }
            
            $response["code"] = 200;
            $response["message"] = "Success";
            $response["data"] = $client->callApi($url."/varion_farmer/_find", $headerParams, $params);
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
            $endpoint = "/varion_farmer_location/_find";
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
                $params["selector"]["FarmerName"] = [ '$regex' => $request->input("name").".*" ];
            }
            
            $strLocation = "location";
            if($request->has("$strLocation") && ($request->input("$strLocation") !== null) && (strlen($request->input("$strLocation")) > 0)){
                $params["selector"]["Name"] = [ '$regex' => $request->input("$strLocation").".*" ];
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

                $count = $client->callApi($url."/varion_farmer_location/_all_docs?limit=0", $headerParams, [], "GET");
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
            $endpoint = "/varion_farmer_to_pulper/_find";
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
                $params["selector"]["FarmerName"] = [ '$regex' => $request->input("name").".*" ];
                $isByParameter = true;
            }
            
            $strId = "id";
            if($request->has("$strId") && ($request->input("$strId") !== null) && (strlen($request->input("$strId")) > 0)){
                $params["selector"]["FarmerID"] = [ '$regex' => $request->input("$strId").".*" ];
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

                $count = $client->callApi($url."/varion_farmer_to_pulper/_all_docs?limit=0", $headerParams, [], "GET");
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
