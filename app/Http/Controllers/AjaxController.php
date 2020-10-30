<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Merk;
use DB;
use Exception;
class AjaxController extends Controller
{ 

    public function get_merk(Request $request) {
      try {
        $response = [
          "error" => true,
          "messages"=> null,
          "data" => null
        ];
        $data = Merk::where('category_id',$request->category_id)->get();

        if(count($data) == 0) {
          $response["messages"] = "data is not found!";
          return json_encode($response);
        } else {
          $response["error"] = false;
          $response['data'] = $data;
          return json_encode($response);
        }
           
      } catch(Exception $e) {
            throw ('updatestockprice error'. $e);
        }
    }

    public function updatestockprice(Request $request) {

    	try {
    		$stock_id = $request->argument;
    		$new_price = $request->new_price;

    		$result = Stock::where('uuid', $stock_id)
          	->where('status', 1)
          	->update(['harga_jual' => $new_price]);


          	$response = [
          		"error" => true,
          		"messages"=> null,
          		"data" => null
          	];

          	if($result == 0) {
          		$response["messages"] = "update harga gagal, please contact your administrator";
          		return json_encode($response);
          	}

          	$response["error"] = false;
          	return json_encode($response);
    	} catch(Exception $e) {
            throw ('updatestockprice error'. $e);
        }

    }


    public function updatetotalstockprice(Request $request) {

    	try {
    		$stock_list = $request->stock_list;

    		$stock_array = explode(",", $stock_list);

    		$result = Stock::whereIn('id', $stock_array)
          	->where('status', 1)
          	->select(DB::raw('SUM(harga_jual) as total'))
          	->first();
 
          	$response = [
          		"error" => true,
          		"messages"=> null,
          		"data" => null
          	];

          	if($result["total"] == 0) {
          		$response["messages"] = "update harga gagal, please contact your administrator";
          		return json_encode($response);
          	}

          	$response["error"] = false;
          	$response["data"] = $result["total"];
          	return json_encode($response);
    	} catch(Exception $e) {
            throw ('updatestockprice error'. $e);
        }

    }

}
