<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Merk;
use App\Models;
use App\Rule;

use Illuminate\Support\Facades\Auth;
use Log;

use App\UserRule;

use DB;
use Exception;


class AjaxController extends Controller
{   
  protected $selected_rule_id_4 = "4";
   public function __construct()
    {
        $this->middleware('auth');
    }


  public function matikan_rule_user(Request $request) {
    $response = [
      "error" => true,
      "messages"=> null,
      "data" => null
    ];

    $data = UserRule::where('user_id',$request->user_id)
    ->where('rule_id',$request->rule_id)
    ->first();


    if($data == null) {
      $response["messages"] = "user_rule is not found!";
      return json_encode($response);
    } else {
      $response["error"] = false;
      $data->status = 0;
      $data->save();
      return json_encode($response);
    }

  }

  public function aktifkan_rule_user(Request $request) {
    $response = [
      "error" => true,
      "messages"=> null,
      "data" => null
    ];

    $data = UserRule::where('user_id',$request->user_id)
    ->where('rule_id',$request->rule_id)
    ->first();


    if($data == null) {
      $response["messages"] = "user_rule is not found!";
      return json_encode($response);
    } else {
      $response["error"] = false;
      $data->status = 1;
      $data->save();
      return json_encode($response);
    }

  }


  public function get_user_rule(Request $request) {
    Log::info('get_user_rule start for request : '. $request->id);
    $response = [
      "error" => true,
      "messages"=> null,
      "data" => null
    ];
    try {
        
        if(Auth::user()->role != 2) {
            $user_rule = UserRule::where('user_id',Auth::user()->id)
                        ->where("rule_id",$this->selected_rule_id_4)
                        ->first();
            $messages = "tidak ada akses ke set rule user!";

            if($user_rule == null || $user_rule->status == 0) {
              $response['messages'] = $messages;
              return json_encode($response);
            }
        }

        $list_user_rule = UserRule::where('user_id',$request->id)->get();

        if(count($list_user_rule) < 1) {
          $rule = Rule::all();

          $full_data = array();
          foreach($rule as $key=>$value) {
            $each_data = array(
              'rule_id' => $value->id,
              'user_id' => $request->id,
              'created_at' => now(),
              'updated_at' => now()
            );
            array_push($full_data, $each_data);
          }
          Log::warning('generate user rule for user : '. $request->id);
          UserRule::insert($full_data);
        } else {
          Log::info('user rule exists for user : '. $request->id);
        }



        $data = Rule::leftJoin('user_rule','user_rule.rule_id','=','rule.id')
        ->leftJoin('users','users.id','=','user_rule.user_id')
        ->where('users.id','=',$request->id)
        ->select(
          'rule.id AS rule_id',
          'rule.name AS rule_name',
          'user_rule.status as rule_status',
          'users.id as user_id'
        )
        ->get();

       if(count($data) == 0) {
          $response["messages"] = "data rule is not found!";
          return json_encode($response);
        } else {
          $response["error"] = false;
          $response['data'] = $data;
          return json_encode($response);
        }
        
      } catch(Exception $e) {
        Log::error('get_user_rule error : '. $e);
        $response["messages"] = $e;
        return json_encode($response);
      }
  }


  public function get_models(Request $request) {
      try {
        $response = [
          "error" => true,
          "messages"=> null,
          "data" => null
        ];
        $data = Models::where('merk_id',$request->merk_id)->get();

        if(count($data) == 0) {
          $response["messages"] = "data models is not found!";
          return json_encode($response);
        } else {
          $response["error"] = false;
          $response['data'] = $data;
          return json_encode($response);
        }
           
      } catch(Exception $e) {
          throw ('get_models error'. $e);
      }
    }


    public function get_merk(Request $request) {
      try {
        $response = [
          "error" => true,
          "messages"=> null,
          "data" => null
        ];
        $data = Merk::where('category_id',$request->category_id)->get();

        if(count($data) == 0) {
          $response["messages"] = "data merk is not found!";
          return json_encode($response);
        } else {
          $response["error"] = false;
          $response['data'] = $data;
          return json_encode($response);
        }
           
      } catch(Exception $e) {
            throw ('get_merk error'. $e);
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
