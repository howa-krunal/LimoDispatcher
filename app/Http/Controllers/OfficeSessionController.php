<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OfficeSessionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function accessSessionData() {
      $branches = DB::table('branches')->get();
      $office_name_arr = array();
      foreach ($branches as $value) {
         $office_name_arr[$value->id] = "[$value->id] $value->branch_name";
      }
      return $office_name_arr;
    }
    public function storeSessionData(Request $request) {
      $request->session()->put('office_ids',$request->limo_office);
      return back()->withInput();
    }
    public function deleteSessionData(Request $request) {
      $request->session()->forget('office_ids');
      echo "Data has been removed from session.";
    }
    public function getCarDriverData(Request $request) {
      $value = $request->value;
      $req_type = $request->req_type;
      $return_val = '<option></option>';
      if($req_type == 'car' || $req_type == 'queue-car'){
        $option_data = DB::table('auto_items')->select('plate_no','id')->where('branch_id',$value)->get();
        foreach ($option_data as $opt_value) {
          $return_val .= '<option value="'.$opt_value->id.'">'.$opt_value->plate_no.'</option>'; 
        }
      } elseif ($req_type == 'driver' || $req_type == 'queue-driver') {
        $option_data = DB::table('driver_details')->select('driver_name','id','com_rate')->where('branch_id',$value)->get();
        foreach ($option_data as $opt_value) {
          $return_val .= '<option value="'.$opt_value->id.'" data-com-rate="'.$opt_value->com_rate.'">'.$opt_value->driver_name.'</option>'; 
        }
      }
      
      return $return_val;
    }
}
