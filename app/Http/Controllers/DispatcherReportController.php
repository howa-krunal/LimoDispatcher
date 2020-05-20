<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Job_vc;
use App\Job_disp;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
//use Auth;

class DispatcherReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public $voucher_status = array('Pending','Plan','Invoice','No Show Charge','No Show Non Charge','Complement','Pkg','House Used','Fast Track');
    public $service_type = array('PICKUP-AIRPORT', 'AIRPORT-TRANSFER','ONEWAY','PICK-UP','HOURLY','OTHER','PATTAYA','ROUND-TRIP' );
    public $cancel_job_status = 'Cancel';
 
    public function __construct(Request $request)
    {
        //$user = auth()->user();
        //$user = Auth::user();
        //echo "<pre>"; print_r($user); exit();
    }

    public function recapitulation(Request $request){
        if($request->session()->has('office_ids')){
            $selected_office = session('office_ids');
            if (sizeof($selected_office) == 1) {
                $default_office_id = $selected_office[0];
            }else {
                $default_office_id = 1;
            } 
        }

        $group_data = DB::table('group_item')->select('group_name')->where('branches_id', $default_office_id)->get();
        $group_arr = array('-'=>'-');
        foreach ($group_data as $value) {
           $group_arr[$value->group_name] = $value->group_name;
        }
        $report_data = array();
        //DB::enableQueryLog();
        if(!empty($request->all())){
            $vc_date = explode(' - ', $request->voucher_date);

            $vc_date[0] = date('Y-m-d',strtotime(str_replace('/', '-', $vc_date[0] )));
            $vc_date[1] = date('Y-m-d',strtotime(str_replace('/', '-', $vc_date[1] )));

            $job_vc = new Job_vc();
            $job_vc = $job_vc->select('job_disps.room_no','job_vc.vc_no','job_vc.vc_date','job_disps.guest_name','job_vc.total_amt','job_disps.vc_status','job_disps.service_type','job_disps.vc_total_hour','job_disps.req_by_emp_name')->join('job_disps', 'job_vc.id', '=', 'job_disps.job_vc_id');
            $job_vc = $job_vc->whereBetween('job_disps.vc_date', $vc_date);
            $job_vc = $job_vc->whereIn('job_disps.branch_id', $selected_office);
            if (!empty($request->vcstatus)) {
                $job_vc = $job_vc->whereIn('job_disps.vc_status', $request->vcstatus);
            }
            if (isset($request->cancel) && $request->cancel == '1' ) {
                $job_vc = $job_vc->where('job_disps.job_status', $cancel_job_status);
            }
            if (isset($request->cancel) && $request->cancel == '0' ) {
                $job_vc = $job_vc->where('job_disps.job_status','!=', $cancel_job_status);
            }
            $report_data = $job_vc->get();
        }
        //dd(DB::getQueryLog());
        return view('dispatcher_report.recapitulation')->with(array('group_name'=>$group_arr,'voucher_status'=>$this->voucher_status,'request'=>$request,'report_data'=>$report_data));
    }

    public function numberoftrip(Request $request){
        if($request->session()->has('office_ids')){
            $selected_office = session('office_ids');
            if (sizeof($selected_office) == 1) {
                $default_office_id = $selected_office[0];
            }else {
                $default_office_id = $selected_office[0];
            } 
        }

        $group_data = DB::table('group_item')->select('group_name')->where('branches_id', $default_office_id)->get();
        $group_arr = array('-'=>'-');
        foreach ($group_data as $value) {
           $group_arr[$value->group_name] = $value->group_name;
        }
        $car_class = DB::table('auto_model')->select('auto_model.id', 'auto_model.model')->get();
        $car_class_arr = array(''=>'');
        foreach ($car_class as $value) {
           $car_class_arr[$value->model] = $value->model;
        }
        $data_report = array();
        if(!empty($request->all())){
            $vc_date = explode(' - ', $request->voucher_date);

            $vc_date[0] = date('Y-m-d',strtotime(str_replace('/', '-', $vc_date[0] )));
            $vc_date[1] = date('Y-m-d',strtotime(str_replace('/', '-', $vc_date[1] )));
            //SELECT COUNT(id),service_type , job_date FROM `job_disps` GROUP BY job_date,service_type
            $job_data = new Job_disp();
            $job_data = $job_data->select( DB::raw("COUNT(id) as number_id"),'service_type','job_date', DB::raw("SUM(trip_amount) as trip_amount"));
            $job_data = $job_data->whereBetween('job_disps.job_date', $vc_date);
            
            if (isset($request->group_name) && !empty($request->group_name) ) {
                //$job_data = $job_data->where('job_disps.group_name', $request->group_name);
            }
            if (isset($request->car_class) && !empty($request->car_class) ) {
                $job_data = $job_data->where('job_disps.vh_type','!=', $request->car_class);
            }
            $job_data = $job_data->groupBy('job_date', 'service_type');
            $report_data = $job_data->get();
            
            foreach ($report_data as $key => $data) {
                if($request->result_by == 'date') {
                    $date_key = $data->job_date;
                }else{
                    $date_key = date("F Y",strtotime($data->job_date));
                }
                $data_report[$date_key][$data->service_type] = array('num_of_record'=> $data->number_id, 'trip_amount'=> $data->trip_amount );
                (isset($data_report[$date_key]['total_rec'])) ? $data_report[$date_key]['total_rec'] += $data->number_id : $data_report[$date_key]['total_rec'] = $data->number_id ;
                (isset($data_report[$date_key]['total_amt'])) ? $data_report[$date_key]['total_amt'] += $data->trip_amount : $data_report[$date_key]['total_amt'] = $data->trip_amount ;
            }
            //echo "<pre>";
            //print_r($data_report);
            //exit();
        }
        return view('dispatcher_report.numberoftrip')->with(array('group_name'=>$group_arr,'service_type'=>$this->service_type,'request'=>$request,'report_data'=>$data_report,'car_class_arr'=>$car_class_arr));
    }
}
