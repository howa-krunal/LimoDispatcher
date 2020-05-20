<?php

namespace App\Http\Controllers;

use Auth;
use App\Job_disp;
use App\Job_vc;
use App\JobAutoQueue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\JobAction;
use PDF;


class DispatcherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $job_status = array('Plan','Assigned','60 mins to prior pickup','Navigate to pickup point','Arrived pickup point','Add waiting time on Pickup Location','Passenger on board','Navigate to destination','Add waiting time during ride','Change of route','Cancel','Trip completed','Close' );
    public $service_type = array('','FROM-AIRPORT', 'TO-AIRPORT','ONEWAY','PICK-UP','HOURLY','OTHER','PATTAYA','ROUND-TRIP' );
    public $voucher_status = array('Pending','Plan','Invoice','No Show Charge','No Show Non Charge','Complement','Pkg','House Used','Fast Track');
    public $close_job_status = 'Close';
        

    public function __construct(){
        $this->job_status = array_combine($this->job_status ,$this->job_status );
        $this->service_type = array_combine($this->service_type ,$this->service_type );
        $this->voucher_status = array_combine($this->voucher_status ,$this->voucher_status );
        if(!session()->has('office_ids')){
            session(['office_ids' => array('1')]);
        }
    }
    public function index()
    {
        $job_type = array('FROM-AIRPORT'=>'bg-color-yellow', 'TO-AIRPORT'=>'bg-color-orange','ONEWAY'=>'','PICK-UP'=>'','HOURLY'=>'','OTHER'=>'','PATTAYA'=>'' ,'ROUND-TRIP'=>'' );
        $selected_office = session('office_ids');
        if (sizeof($selected_office) == 1) {
            $default_office_id = $selected_office[0];
        }else {
            $default_office_id = 1;
        }
       
        return view('dispatcher.index')
            ->with( array( 'job_type' => $job_type));
    }
    public function jobList(Request $request){
        $selected_office = session('office_ids');
        if (sizeof($selected_office) == 1) {
            $default_office_id = $selected_office[0];
        }else {
            $default_office_id = 1;
        }
        if ($request->id == 'tab_1') {
            $all_job_list = Job_disp::latest()->select('job_disps.*','branches.short_name')->join('branches', 'branches.id', '=', 'job_disps.branch_id')->whereIn('branch_id', $selected_office)->whereDate('job_date',date('Y-m-d'))->where('job_status','!=',$this->close_job_status)->where('req_by_type','0')->orderBy('job_disps.job_date', 'DESC')->orderBy('job_disps.job_time', 'DESC')->get();
        }else if ($request->id == 'tab_2') {
            $all_job_list = Job_disp::latest()->select('job_disps.*','branches.short_name')->join('branches', 'branches.id', '=', 'job_disps.branch_id')->whereIn('branch_id', $selected_office)->whereDate('job_date','>',date('Y-m-d'))->where('req_by_type','0')->orderBy('job_disps.job_date', 'DESC')->orderBy('job_disps.job_time', 'DESC')->get();
        }else if ($request->id == 'tab_3') {
            $all_job_list = Job_disp::latest()->select('job_disps.*','branches.short_name')->join('branches', 'branches.id', '=', 'job_disps.branch_id')->whereIn('branch_id', $selected_office)->whereDate('job_date','!=',date('Y-m-d'))->where('req_by_type','0')->orderBy('job_disps.job_date', 'DESC')->orderBy('job_disps.job_time', 'DESC')->get();
        }else if ($request->id == 'tab_4') {
            $all_job_list = Job_disp::latest()->select('job_disps.*','branches.short_name')->join('branches', 'branches.id', '=', 'job_disps.branch_id')->whereIn('branch_id', $selected_office)->where('req_by_type','1')->orderBy('job_disps.job_date', 'DESC')->orderBy('job_disps.job_time', 'DESC')->get();
        }
        
        return datatables()->of($all_job_list)
            ->addColumn('show_action', function($row){
                return route('dispatcher.show',$row->id);
            })->addColumn('edit_action', function($row){
                return route('dispatcher.edit',$row->id);
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $ref_job_id = 0)
    {
        if($request->session()->has('office_ids')){
            $selected_office = session('office_ids');
            if (sizeof($selected_office) == 1) {
                $default_office_id = $selected_office[0];
            }else {
                $default_office_id = 1;
            } 
        }
        
        //$job_status = array('Plan','60 mins to prior pickup','Navigate to pickup point','Arrived pickup point','Add waiting time on Pickup Location','Passenger on board','Navigate to destination','Add waiting time during ride','Change of route','Trip completed','Close' );
        
        
        $car_class = DB::table('auto_model')->join('auto_brand', 'auto_model.auto_brand_id', '=', 'auto_brand.id')->select('auto_model.id', 'auto_model.model','auto_brand.brand')->get();
        $car_class_arr = array(''=>'');
        foreach ($car_class as $value) {
           $car_class_arr[$value->id] = "$value->model :: $value->brand";
        }

        $branches = DB::table('branches')->get();
        $office_name_arr = array('0'=>'Others');
        $branch_name_arr = array();

        foreach ($branches as $value) {
           $office_name_arr[$value->id] = "$value->id :: $value->branch_name";
           if ($request->session()->has('office_ids') && in_array($value->id, session('office_ids'))) {
               $branch_name_arr[$value->id] = "$value->id :: $value->branch_name";
           }
        }

        $group_data = DB::table('group_item')->select('group_name')->where('branches_id', $default_office_id)->get();
        $group_arr = array('-'=>'-');
        foreach ($group_data as $value) {
           $group_arr[$value->group_name] = $value->group_name;
        }

        return view('dispatcher.create')->with(array('service_type'=> $this->service_type,'job_status'=>$this->job_status,'voucher_status'=>$this->voucher_status,'car_class_arr'=>$car_class_arr,'office_name_arr'=>$office_name_arr,'group_name'=>$group_arr,'default_office_id'=>$default_office_id,'selected_office'=>$selected_office,'branch_name_arr'=>$branch_name_arr,'ref_job_id'=>$ref_job_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->session()->has('office_ids')){
            $selected_office = session('office_ids');
            if (sizeof($selected_office) == 1) {
                $default_office_id = $selected_office[0];
            }else {
                $default_office_id = 1;
            }            
        }
        if (isset($request->branch)) {
            $default_office_id = $request->branch;
        }
        $new_job = new Job_disp();
        $car_details = DB::table('auto_model')->join('auto_brand', 'auto_model.auto_brand_id', '=', 'auto_brand.id')->select('auto_model.id', 'auto_model.model','auto_brand.brand')->where('auto_model.id',$request->car_class)->first();
        $job_status = $request->job_status;
        if (!empty($request->car_no) && !empty($request->driver_code) && $request->job_status == 'Plan') {
            $job_status = 'Assigned';
        }
        
        $last = DB::table('job_disps')->select('booking_no')->latest()->first();
        $new_job->booking_no = 'DJ'.(substr($last->booking_no, 2)+1);
        $new_job->req_by_user_id = $request->description;
        $new_job->branch_id = $default_office_id;
        $new_job->job_date = date('Y-m-d', $this->changeDateFormate($request->service_date));
        $new_job->job_time = $request->service_time;
        $new_job->vh_type_id = $request->car_class;
        $new_job->vh_brand = $car_details->brand;
        $new_job->vh_type = $car_details->model;
        $new_job->booking_date = date('Y-m-d H:i:s', $this->changeDateFormate($request->booking_date.' '.$request->booking_time));
        $new_job->group_name = $request->group_name;
        $new_job->service_type = $request->service_type;
        $new_job->other_desc = $request->other_desc;
        $new_job->guest_name = $request->guest_name;
        $new_job->flight_detail = $request->flight_detail;
        $new_job->room_no = $request->room_no;
        $new_job->company = $request->company;
        $new_job->req_by_emp_name = empty($request->request_by) ? Auth::user()->name : $request->request_by;
        $new_job->job_status = $job_status;
        $new_job->job_remark = $request->job_remark;
        $new_job->vc_status = $request->voucher_status;
        $new_job->vc_date = (!empty($request->invoice_date)) ? date('Y-m-d', $this->changeDateFormate($request->invoice_date)) : NULL;
        $new_job->vc_total_hour = $request->vc_total_hour;
        $new_job->vh_office_id = (!empty($request->car_no)) ? $request->car_office : NULL;
        $new_job->vh_id = $request->car_no;
        $new_job->vh_no = $request->plate_no;
        $new_job->driver_office_id = (!empty($request->driver_code)) ? $request->driver_office : NULL;
        $new_job->driver_id = $request->driver_code;
        $new_job->driver_name = $request->driver_name;
        $new_job->driver_comm_rate = $request->commission_rate;
        $new_job->vh_mile_out = $request->mile_out;
        $new_job->vh_mile_in = $request->mile_in;
        $new_job->vh_mile_run = $request->mile_run;
        $new_job->vh_out_time = (!empty($request->time_out_d)) ? date('Y-m-d H:i:s', $this->changeDateFormate($request->time_out_d.' '.$request->time_out_t)) : NULL;
        $new_job->vh_in_time = (!empty($request->time_in_d)) ? date('Y-m-d H:i:s', $this->changeDateFormate($request->time_in_d.' '.$request->time_in_t)) : NULL;
        $new_job->trip_amount = $request->trip_amt;
        $new_job->referance_no = $request->referance_no;
        $new_job->req_vc_no = $request->req_vc_no;
        $new_job->req_price = $request->req_price;
        $new_job->req_by_user_id = Auth::id();
        $new_job->pickup_address = $request->pickup_location;
        $new_job->pickup_lat = $request->pickup_lat;
        $new_job->pickup_lng = $request->pickup_lng;
        $new_job->drop_address = $request->drop_location;
        $new_job->drop_lat = $request->drop_lat;
        $new_job->drop_lng = $request->drop_lng;

        $new_job->save();
        $this->sendJobData($new_job->id);
        
        //activity()->performedOn($update_job)->log('Created-Job');
        //activity('default')->performedOn($new_job)->log('Created-Job');
        if ($request->service_type == 'ROUND-TRIP') {
            return $this->create($request,$new_job->id);
        }else{
            return redirect()->route('dispatcher.index')->with('success', 1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job_disp  $job_disp
     * @return \Illuminate\Http\Response
     */
    public function show($id,Job_disp $job_disp)
    {
        $where = array('job_disps.id' => $id);
        $job_disp_data = $job_disp->select('job_disps.*','job_extra_details.app_detail')->leftjoin('job_extra_details','job_extra_details.job_disps_id','=','job_disps.id')->where($where)->first();
        
        $car_class = DB::table('auto_model')->join('auto_brand', 'auto_model.auto_brand_id', '=', 'auto_brand.id')->select('auto_model.id', 'auto_model.model','auto_brand.brand')->get();
        $car_class_arr = array(''=>'');
        foreach ($car_class as $value) {
           $car_class_arr[$value->id] = "$value->model :: $value->brand";
        }

        $branches = DB::table('branches')->get();
        $office_name_arr = array('0'=>'Others');
        foreach ($branches as $value) {
           $office_name_arr[$value->id] = "$value->id :: $value->branch_name";
        }

        $group_data = DB::table('group_item')->select('group_name')->whereIn('branches_id', session('office_ids'))->get();
        $group_arr = array('-'=>'-');
        foreach ($group_data as $value) {
           $group_arr[$value->group_name] = $value->group_name;
        }

        $job_vc = DB::table('job_vc')->where('job_disps_id', $id)->first();
        $app_data = json_decode($job_disp_data->app_detail,true);
        //echo "<pre>"; print_r($app_data[0]);exit();
        return view('dispatcher.show',compact('job_disp_data'))->with(array('service_type'=> $this->service_type,'job_status'=>$this->job_status,'voucher_status'=>$this->voucher_status,'car_class_arr'=>$car_class_arr,'office_name_arr'=>$office_name_arr,'group_name'=>$group_arr,'job_vc'=>$job_vc));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job_disp  $job_disp
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Job_disp $job_disp,Request $request)
    {
        if($request->session()->has('office_ids')){
            $selected_office = session('office_ids');
            if (sizeof($selected_office) == 1) {
                $default_office_id = $selected_office[0];
            }else {
                $default_office_id = 1;
            } 
        }

        $where = array('id' => $id);
        $job_disp_data = $job_disp->where($where)->first();
        
        $car_class = DB::table('auto_model')->join('auto_brand', 'auto_model.auto_brand_id', '=', 'auto_brand.id')->select('auto_model.id', 'auto_model.model','auto_brand.brand')->get();
        $car_class_arr = array(''=>'');
        foreach ($car_class as $value) {
           $car_class_arr[$value->id] = "$value->model :: $value->brand";
        }

        $branches = DB::table('branches')->get();
        $office_name_arr = array('0'=>'Others');
        foreach ($branches as $value) {
           $office_name_arr[$value->id] = "$value->id :: $value->branch_name";
        }

        $group_data = DB::table('group_item')->select('group_name')->whereIn('branches_id', session('office_ids'))->get();
        $group_arr = array('-'=>'-');
        foreach ($group_data as $value) {
           $group_arr[$value->group_name] = $value->group_name;
        }        
        return view('dispatcher.edit',compact('job_disp_data'))->with(array('service_type'=> $this->service_type,'job_status'=>$this->job_status,'voucher_status'=>$this->voucher_status,'car_class_arr'=>$car_class_arr,'default_office_id'=>$default_office_id,'office_name_arr'=>$office_name_arr,'group_name'=>$group_arr));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job_disp  $job_disp
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $update_job = new Job_disp();
        $car_details = DB::table('auto_model')->join('auto_brand', 'auto_model.auto_brand_id', '=', 'auto_brand.id')->select('auto_model.id', 'auto_model.model','auto_brand.brand')->where('auto_model.id',$request->car_class)->first();
        
        $job_status = $request->job_status;
        if (!empty($request->car_no) && !empty($request->driver_code) && $request->job_status == 'Plan') {
            $job_status = 'Assigned';
        }
        
        $update['req_by_user_id'] = $request->description;
        $update['job_date'] = date('Y-m-d', $this->changeDateFormate($request->service_date));
        $update['job_time'] = $request->service_time;
        $update['vh_type_id'] = $request->car_class;
        $update['vh_brand'] = $car_details->brand;
        $update['vh_type'] = $car_details->model;
        $update['booking_date'] = date('Y-m-d H:i:s', $this->changeDateFormate($request->booking_date.' '.$request->booking_time));
        $update['group_name'] = $request->group_name;
        $update['service_type'] = $request->service_type;
        $update['other_desc'] = $request->other_desc;
        $update['guest_name'] = $request->guest_name;
        $update['flight_detail'] = $request->flight_detail;
        $update['room_no'] = $request->room_no;
        $update['company'] = $request->company;
        $update['req_by_emp_name'] = empty($request->request_by) ? Auth::user()->name : $request->request_by;
        $update['job_status'] = $job_status;
        $update['job_remark'] = $request->job_remark;
        $update['vc_status'] = $request->voucher_status;
        $update['vc_date'] = (!empty($request->invoice_date)) ? date('Y-m-d', $this->changeDateFormate($request->invoice_date)) : NULL;
        $update['vc_total_hour'] = $request->vc_total_hour;
        $update['vh_office_id'] = (!empty($request->car_no)) ? $request->car_office : NULL;
        $update['vh_id'] = $request->car_no;
        $update['vh_no'] = $request->plate_no;
        $update['driver_office_id'] = (!empty($request->driver_code)) ? $request->driver_office : NULL;
        $update['driver_id'] = $request->driver_code;
        $update['driver_name'] = $request->driver_name;
        $update['driver_comm_rate'] = $request->commission_rate;
        $update['vh_mile_out'] = $request->mile_out;
        $update['vh_mile_in'] = $request->mile_in;
        $update['vh_mile_run'] = $request->mile_run;
        $update['vh_out_time'] = (!empty($request->time_out_d)) ? date('Y-m-d H:i:s', $this->changeDateFormate($request->time_out_d.' '.$request->time_out_t)) : NULL;
        $update['vh_in_time'] = (!empty($request->time_in_d)) ? date('Y-m-d H:i:s', $this->changeDateFormate($request->time_in_d.' '.$request->time_in_t)) : NULL;
        $update['trip_amount'] = $request->trip_amt;
        //$update['referance_no'] = $request->referance_no;
        //$update['req_vc_no'] = $request->req_vc_no;
        //$update['req_price'] = $request->req_price;
        //$update['pickup_address'] = $request->pickup_location;
        //$update['pickup_lat'] = $request->pickup_lat;
        //$update['pickup_lng'] = $request->pickup_lng;
        //$update['drop_address'] = $request->drop_location;
        //$update['drop_lat'] = $request->drop_lat;
        //$update['drop_lng'] = $request->drop_lng;

        $update_job->where('id',$id)->update($update);
        $this->sendJobData($id);

        if ($request->changed_driver_option == 'opt_1' || $request->changed_driver_option == 'opt_2') {

            $low_auto_id = DB::table('job_auto_queue')->min('id');
            

            $new_auto_queue = new JobAutoQueue();
            if($request->changed_driver_option == 'opt_1'){
                $new_auto_queue->id = $low_auto_id-1;
            }
            $new_auto_queue->branch_id = $request->old_driver_office;
            $new_auto_queue->driver_office_id = $request->old_driver_office;
            $new_auto_queue->driver_id = $request->old_driver_code;
            $new_auto_queue->driver_name = $request->old_driver_name;
            $new_auto_queue->last_date = date('Y-m-d H:i:s');
            $new_auto_queue->vh_office_id = $request->old_car_office;
            $new_auto_queue->vh_id = $request->old_car_no;
            $new_auto_queue->vh_no = $request->old_plate_no;

            $new_auto_queue->save();
        }
        //activity('default')->performedOn($update_job)->log('Edited-Job');
        return redirect()->route('dispatcher.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job_disp  $job_disp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job_disp $job_disp)
    {
        //
    }

    public function voucher(Request $request){

        if(!empty($request->dispatcher_voucher_id)){
            $job_vc = \App\Job_vc::find($request->dispatcher_voucher_id);
        }else{
            $job_vc = new Job_vc();
            $last = DB::table('job_vc')->select('vc_no')->where('vc_no','LIKE','VC%')->latest()->first();
            if(!empty($request->voucher_no)){
                $vc_no = $request->voucher_no;
            } else {
                $vc_no = 'VC'.str_pad((substr($last->vc_no, 2)+1), 9, '0', STR_PAD_LEFT);
            }
            $job_vc->vc_no = $vc_no;
        }      
        
        $job_vc->job_disps_id = $request->dispatcher_job_id;
        $job_vc->vc_date = date('Y-m-d', $this->changeDateFormate($request->vc_created_date));
        $job_vc->vc_time = $request->vc_created_time;
        $job_vc->ref_voucher_no = $request->ref_voucher_no;
        $job_vc->ref_vc_amt = $request->ref_vc_amt;
        $job_vc->vc_type = $request->vc_payment_type;
        $job_vc->pk_id = $request->package_no;
        $job_vc->pk_name = $request->package_name;
        $job_vc->pk_group = $request->package_group;
        $job_vc->pk_discount = $request->package_disc;
        $job_vc->total_amt = $request->total_amt;
        $job_vc->hotel_airport_flight_no = $request->at_flight_no;
        $job_vc->hotel_airport_time = $request->at_time;
        $job_vc->hotel_airport_price = $request->at_price;
        $job_vc->hotel_airport_discount = $request->at_discount;
        $job_vc->hotel_airport_amt = $request->at_amount;
        $job_vc->airport_hotel_flight_no = $request->pa_flight_no;
        $job_vc->airport_hotel_time = $request->pa_time;
        $job_vc->airport_hotel_price = $request->pa_price;
        $job_vc->airport_hotel_discount = $request->pa_discount;
        $job_vc->airport_hotel_amt = $request->pa_amount;
        $job_vc->per_hour_flight_no = $request->ph_start_time;
        $job_vc->per_hour_time = $request->ph_to;
        $job_vc->per_hour_price = $request->ph_price;
        $job_vc->per_hour_discount = $request->ph_discount;
        $job_vc->per_hour_amt = $request->ph_amount;
        $job_vc->other_description_1 = $request->other_desc_1;
        $job_vc->other_price_1 = $request->other_price_1;
        $job_vc->other_discount_1 = $request->other_discount_1;
        $job_vc->other_amt_1 = $request->other_amount_1;
        $job_vc->other_description_2 = $request->other_desc_2;
        $job_vc->other_price_2 = $request->other_price_2;
        $job_vc->other_discount_2 = $request->other_discount_2;
        $job_vc->other_amt_2 = $request->other_amount_2;
        $job_vc->other_description_3 = $request->other_desc_3;
        $job_vc->other_price_3 = $request->other_price_3;
        $job_vc->other_discount_3 = $request->other_discount_3;
        $job_vc->other_amt_3 = $request->other_amount_3;
        $job_vc->patking_fees = $request->patking_fees;
        $job_vc->patking_fees_price = $request->patking_fees_price;
        $job_vc->patking_fees_discount = $request->patking_fees_discount;
        $job_vc->patking_fees_amount = $request->patking_fees_amount;
        $job_vc->toll_fees = $request->toll_fees;
        $job_vc->toll_fees_price = $request->toll_fees_price;
        $job_vc->toll_fees_discount = $request->toll_fees_discount;
        $job_vc->toll_fees_amount = $request->toll_fees_amount;
        $job_vc->other_misc = $request->other_misc;
        $job_vc->other_misc_price = $request->other_misc_price;
        $job_vc->other_misc_discount = $request->other_misc_discount;
        $job_vc->other_misc_amount = $request->other_misc_amount;
        
        $job_vc->save();
        
        Job_disp::where('id', $request->dispatcher_job_id)->update(['job_vc_id' => $job_vc->id]);
        //activity()->performedOn($job_vc)->log('Edited-Voucher');
        return array('success' =>1 );
    }

    public function changeDateFormate($date_time){
        return strtotime(str_replace('/', '-', $date_time ));
    }
    public function downloadPDF(Request $request){
      //$user = UserDetail::find($id);
        $branches = DB::table('branches')->select('branches.short_name','branches.id')->get();
        $office_name_arr = array();
        foreach ($branches as $value) {
           $office_name_arr[$value->id] = "$value->short_name";
        }
        $job_disp = new Job_disp();

        $where['job_disps.id'] = $request->dispatcher_job_id;
        $job_disp_data = $job_disp->select('job_disps.*','driver_details.phone','job_vc.vc_no','job_vc.total_amt')->leftJoin('job_vc', 'job_vc.job_disps_id', '=', 'job_disps.id')->leftJoin('driver_details', 'job_disps.driver_office_id', '=', 'driver_details.id')->where($where)->first();
        
        if ($request->print_type == 'a4') {
            $pdf = PDF::loadView('dispatcher.pdf', compact(['job_disp_data','office_name_arr']));
        }elseif ($request->print_type == 'a5') {
            $pdf = PDF::loadView('dispatcher.pdf', compact(['job_disp_data','office_name_arr']))->setPaper('A5', 'landscape');
        }else{
            $service_type = array('PICKUP-AIRPORT'=>'PICK-A/P', 'AIRPORT-TRANSFER'=>'A/P-TRAN','ONEWAY'=>'ONEWAY','PICK-UP'=>'PICK UP','HOURLY'=>'HOURLY','OTHER'=>'OTHER','PATTAYA'=>'PATTAYA' );
            $pdf = PDF::loadView('dispatcher.job_form', compact(['job_disp_data','office_name_arr','service_type']));
            //return view('dispatcher.job_form',compact(['job_disp_data','office_name_arr','service_type']));
        }
        
        return $pdf->download('invoice.pdf');
    }
    public function jobSearchByLocation(Request $request){
        $job_type = array('PICKUP-AIRPORT'=>'bg-color-yellow', 'AIRPORT-TRANSFER'=>'bg-color-orange','ONEWAY'=>'','PICK-UP'=>'','HOURLY'=>'','OTHER'=>'','PATTAYA'=>'' );
        $service_type = array('ALL' => 'ALL' ,'AIRPORT-TRANSFER' => 'AIRPORT-TRANSFER' ,'PATTAYA' => 'PATTAYA' );
        $search_data = $request->all();
        $search_job = new Job_disp();
        $job_list = array();
        if (!empty($search_data)) {
            $search_job = $search_job->select('job_disps.*','branches.short_name')->join('branches', 'branches.id', '=', 'job_disps.branch_id')->orderBy('job_disps.job_date', 'DESC')->orderBy('job_disps.job_time', 'DESC');

            if(isset($search_data['service_type']) && $search_data['service_type'] == 'AIRPORT-TRANSFER'){
                $search_job = $search_job->where(function ($query) {
                    $query->where('service_type', 'AIRPORT-TRANSFER')->orWhere('service_type', 'PICKUP-AIRPORT');
                });     
            }else if(isset($search_data->service_type) && $search_data['service_type'] == 'PATTAYA'){
                $search_job = $search_job->where('service_type', 'PATTAYA');
            }
            if(isset($search_data['require_date']) && isset($search_data['require_time']) && !empty($search_data['require_date']) && !empty($search_data['require_time'])){
                $search_job = $search_job->whereDate('job_date', date('Y-m-d', $this->changeDateFormate($search_data['require_date'])));
                $search_job = $search_job->whereBetween('job_time', [date('H:i',strtotime($search_data['require_time']) - (60*60*1)), date('H:i',strtotime($search_data['require_time']) + (60*60*1) )]);
            }
            if(isset($search_data['desc']) && !empty($search_data['desc'])){
                $search_job = $search_job->where('other_desc', 'like', '%'.$search_data['desc'].'%');
            }
            $job_list = $search_job->get();
        }

        
        return view('dispatcher.searchbylocation',compact('job_list'))
            ->with($arrayName = array( 'job_type' => $job_type, 'service_type'=>$service_type,'search_data'=>$search_data));
    }

    public function showCarDriver($id,Job_disp $job_disp)
    {
        $where = array('job_disps.id' => $id);
        $job_disp_data = $job_disp->select('job_disps.*','users.name as created_by_name')->join('users', 'users.id', '=', 'job_disps.req_by_user_id')->where($where)->first();
        
        $car_class = DB::table('auto_model')->join('auto_brand', 'auto_model.auto_brand_id', '=', 'auto_brand.id')->select('auto_model.id', 'auto_model.model','auto_brand.brand')->get();
        $car_class_arr = array(''=>'');
        foreach ($car_class as $value) {
           $car_class_arr[$value->id] = "$value->model :: $value->brand";
        }

        $branches = DB::table('branches')->get();
        $office_name_arr = array('0'=>'Others');
        foreach ($branches as $value) {
           $office_name_arr[$value->id] = "$value->id :: $value->branch_name";
        }

        $group_data = DB::table('group_item')->select('group_name')->whereIn('branches_id', session('office_ids'))->get();
        $group_arr = array('-'=>'-');
        foreach ($group_data as $value) {
           $group_arr[$value->group_name] = $value->group_name;
        }

        $job_vc = DB::table('job_vc')->where('job_disps_id', $id)->first();

        return view('dispatcher.show_car_driver',compact('job_disp_data'))->with(array('service_type'=> $this->service_type,'job_status'=>$this->job_status,'voucher_status'=>$this->voucher_status,'car_class_arr'=>$car_class_arr,'office_name_arr'=>$office_name_arr,'group_name'=>$group_arr,'job_vc'=>$job_vc));
    }
    public function updateJobStatus($id,$status){
        if (!empty($id)) {
            if (isset($status) && !empty($status)) {
                // $update_job = new Job_disp();

                // $update['job_status'] = $status;

                // $update_job->where('referance_no',$id)->update($update);
                
                $update_job = Job_disp::where('referance_no',$id)->first();
                $update_job->job_status =  rawurldecode($status);
                
                if (rawurldecode($status) == '60 mins to prior pickup') {
                    $update_job->vh_out_time = date('Y-m-d H:i:s');
                }
                if (rawurldecode($status) == 'Trip completed') {
                    $update_job->vh_in_time = date('Y-m-d H:i:s');
                    $update_job->vc_status = 'Invoice';
                }
                $update_job->save();
                \Notification::send(User::all(),new JobAction($update_job));
                return json_encode(array('success' => true,'data'=>$update_job ));
            } else {
                return json_encode(array('error' =>'Job status must required' ));
            }   
        } else {
            return json_encode(array('error' =>'Id must required' ));
        }
    }
    public function addAdditionalExpense(Request $request){

        if (!empty($request->id)) {
            $job_disps_data = DB::table('job_disps')->select('job_disps.id','job_vc.id as job_vc_id')->leftjoin('job_vc', 'job_disps.id', '=', 'job_vc.job_disps_id')->where('referance_no', $request->id)->first();
            if(!empty($job_disps_data)) {
                if(!empty($job_disps_data->job_vc_id)){
                    $job_vc = \App\Job_vc::find($job_disps_data->job_vc_id);
                    $total_amt = $job_vc->total_amt;
                }else{
                    $job_vc = new Job_vc();
                    $last = DB::table('job_vc')->select('vc_no')->where('vc_no','LIKE','VC%')->latest()->first();
                    $vc_no = 'VC'.str_pad((substr($last->vc_no, 2)+1), 9, '0', STR_PAD_LEFT);

                    $job_vc->vc_no = $vc_no;
                    $job_vc->vc_date = date('Y-m-d');
                    $job_vc->vc_time = date('H:i');
                    $total_amt = 0;
                }      
                
                $job_vc->job_disps_id = $job_disps_data->id;
                
                $job_vc->patking_fees = $request->parking_fees;
                $job_vc->patking_fees_price = $request->parking_fees_price;
                $job_vc->patking_fees_amount = $request->parking_fees_price;
                $job_vc->toll_fees = $request->toll_fees;
                $job_vc->toll_fees_price = $request->toll_fees_price;
                $job_vc->toll_fees_amount = $request->toll_fees_price;
                $job_vc->other_misc = $request->miscellaneous_exp;
                $job_vc->other_misc_price = $request->miscellaneous_exp_price;
                $job_vc->other_misc_amount = $request->miscellaneous_exp_price;
                $job_vc->total_amt = $request->miscellaneous_exp_price + $request->toll_fees_price + $request->parking_fees_price + $total_amt;
                
                $job_vc->save();
                $Idate = date('Y-m-d');
                Job_disp::where('id', $job_disps_data->id)->update(['job_vc_id' => $job_vc->id, 'vc_date'=>$Idate]);
                //activity()->performedOn($job_vc)->log('Edited-Voucher');
                return json_encode(array('success' => true ));
            } else{
                return json_encode(array('error' =>'Invalid id' ));
            }
        }else{
            return json_encode(array('error' =>'Id must required' ));
        }
    }
    public function sendJobData($job_id){

        $job_disp = new Job_disp(); 
        $where = array('job_disps.id' => $job_id);
        $job_disp_data = $job_disp->select('job_disps.id','job_date','job_time','service_type','guest_name','flight_detail','room_no','company','job_status','job_remark','vh_no','driver_name','trip_amount','pickup_address','pickup_lat','pickup_lng','drop_address','drop_lat','drop_lng','booking_no','auto_model.car_class_id','other_desc as other_detail','referance_no')->leftJoin('auto_model', 'auto_model.id', '=', 'job_disps.vh_type_id')->where($where)->first()->toJson();
        //echo $job_disp_data; exit();

        if(!empty($job_disp_data)) {
                /* API URL */
            $url = 'http://103.20.207.189:8081/smart_limo/rideBookingFromDispatcher';
            //$url = 'http://localhost:8081/smart_limo/rideBookingFromDispatcher';
       
            /* Init cURL resource */
            $ch = curl_init($url);
       
            /* pass encoded JSON string to the POST fields */
            curl_setopt($ch, CURLOPT_POSTFIELDS, $job_disp_data);
                
            /* set the content type json */
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                
            /* set return type json */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
            /* execute request */
            $result = curl_exec($ch);

            $data = json_decode($result,true);
            if (isset($data['success']) && $data['success'] && isset($data['data']['id'])) {
                # code...
                //print_r($data['data']['id']);exit();
                $update_job = new Job_disp();

                $update['referance_no'] = $data['data']['id'];

                $update_job->where('id', $job_id)->update($update);
            }
                 
            /* close cURL resource */
            curl_close($ch);
        }
    }
    public function addCompletedJobDetails(Request $request){

        if (!empty($request->id)) {
            $job_disps_data = Job_disp::select('job_disps.id')->where('referance_no', $request->id)->first();
            if(!empty($job_disps_data)) {
                $app_detail['ride_all_status'] = $request->ride_status; 
                $app_detail['ride_extra_charges'] = $request->ride_extra_charges; 
                DB::table('job_extra_details')->updateOrInsert(
                        ['job_disps_id' => $job_disps_data->id],
                        ['app_detail' => json_encode($app_detail)]
                    );
                //activity()->performedOn($job_vc)->log('Edited-Voucher');
                return json_encode(array('success' => true ));
            } else{
                return json_encode(array('error' =>'Invalid id' ));
            }
        }else{
            return json_encode(array('error' =>'Id must required' ));
        }
    }
    public function updateMileageData($id,$status,$value){
        if (!empty($id)) {
            if (isset($status) && !empty($status)) {
                $update_job = Job_disp::where('referance_no',$id)->first();
                
                if ($status == 'mileage_out') {
                    $update_job->vh_mile_out = $value;
                }
                if ($status == 'mileage_in') {
                    $update_job->vh_mile_in = $value;
                    $update_job->vh_mile_run = $value - $update_job->vh_mile_out;
                }
                $update_job->save();
                
                return json_encode(array('success' => true,'data'=>$update_job ));
            } else {
                return json_encode(array('error' =>'Job status must required' ));
            }   
        } else {
            return json_encode(array('error' =>'Id must required' ));
        }
    }
}
