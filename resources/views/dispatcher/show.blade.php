@extends('layouts.admin')
@section('content')
@php
$booking_date = $booking_time = '';
if(!empty($job_disp_data->booking_date)){
	$booking = explode(" ", $job_disp_data->booking_date);
	$booking_date = $booking[0];
	$booking_time = $booking[1];
}
$time_out_date = $time_out_time = '';
if(!empty($job_disp_data->vh_out_time)){
	$time_out = explode(" ", $job_disp_data->vh_out_time);
	$time_out_date = $time_out[0];
	$time_out_time = $time_out[1];
}
$time_in_date = $time_in_time = '';
if(!empty($job_disp_data->vh_in_time)){
	$time_in = explode(" ", $job_disp_data->vh_in_time);
	$time_in_date = $time_in[0];
	$time_in_time = $time_in[1];
}
$edit_vc = 0;
$vc_no = $vc_amt = '';
if(!empty($job_vc)){
	$edit_vc = 1;
	$vc_no = $job_vc->vc_no;
	$vc_amt = $job_vc->total_amt;
}
$app_details = json_decode($job_disp_data->app_detail,true);
$ride_extra_info = array('waiting_time_on_pickup_location','waiting_charge_on_pickup_location','waiting_time_during_ride','waiting_charge_during_ride','route_change_extra_distance','route_change_extra_charge','route_change_drop_address','ride_total_time','route_change_dropoff_latitude','route_change_dropoff_longitude');
@endphp
<div class="card">
	<div class="card-header py-1">
    	<h3 class="card-title">View Job</h3>
    	<div class="float-right">
      		<a class="btn btn-primary px-2 py-1" data-toggle="modal" href="" data-target="#modal-print"> Print</a>
      		<a class="btn btn-primary px-2 py-1" href="{{ route('dispatcher.edit',$job_disp_data->id) }}"> Edit</a>
      		<a class="btn btn-secondary px-2 py-1" href="{{ route('dispatcher.index') }}"> Back</a>
    	</div>
	</div>
	<div class="card-body overflow-auto p-1">
	    @csrf
	    <div class="row mx-0">
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('service_date', 'Service Date',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('service_date', date('d/m/Y',strtotime($job_disp_data->job_date)),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('service_time', 'Service Time',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('service_time', substr($job_disp_data->job_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('referance_no', 'Referance No.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('referance_no', $job_disp_data->referance_no,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('car_class', 'Car Class',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::select('car_class', $car_class_arr,$job_disp_data->vh_type_id,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('booking_date', 'Booking',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('booking_date', date('d/m/Y',strtotime($booking_date)),array('class'=>'form-control form-control-sm col-sm-5','readonly'=>'readonly')) }} 
	                {{ Form::text('booking_time', substr($booking_time, 0, -3) ,array('class'=>'form-control form-control-sm col-sm-3','readonly'=>'readonly')) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('group_name', 'Group Name',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::select('group_name', $group_name,$job_disp_data->group_name,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('service_type', 'Service Type',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::select('service_type',$service_type,$job_disp_data->service_type,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('other_desc', 'Other Desc.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('other_desc', $job_disp_data->other_desc,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('req_vc_no', 'Req. Vc. No.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('req_vc_no', $job_disp_data->req_vc_no,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('guest_name', 'Guest Name',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('guest_name', $job_disp_data->guest_name,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('flight_detail', 'Flight Detail',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('flight_detail', $job_disp_data->flight_detail,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('req_price', 'Req. Price',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('req_price', $job_disp_data->req_price,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('room_no', 'Room No.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('room_no', $job_disp_data->room_no,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('company', 'Company',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('company', $job_disp_data->company,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('request_by', 'Request By',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('request_by', $job_disp_data->req_by_emp_name,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('job_status', 'Job Status',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::select('job_status',$job_status,$job_disp_data->job_status,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('car_office', 'Car Office',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::select('car_office', $office_name_arr, $job_disp_data->vh_office_id,['class'=>'form-control form-control-sm col-sm-7 dynamic-office','data-req-type'=>'car','disabled'=>'disabled']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	        	<div class="form-group row mx-0 mb-2">
	            	{{ Form::label('plate_no', 'Plate No.',['class'=>'col-sm-4 text-right']) }}
					{{ Form::text('plate_no', $job_disp_data->vh_no ,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
                </div>
	        </div>
	        <div class="col-lg-12 px-0">
	        	<div class="row mx-0">
	        		<div class="col-sm-4 px-0">
	        			<div class="col-xs-12 col-sm-12 col-md-12">
				            <div class="form-group row mx-0 mb-2">
				                {{ Form::label('job_remark', 'Job Remark',['class'=>'col-sm-4 text-right']) }}
				                {{ Form::textarea('job_remark', $job_disp_data->job_remark,['rows'=>'6','class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly'] )}} 
				            </div>
				        </div>
	        		</div>
	        		<div class="col-sm-8 px-0">
	        			<div class="row mx-0">
		        			<div class="col-xs-12 col-sm-6 col-md-6">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('car_no', 'Car No',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::select('car_no', ['' => ''],$job_disp_data->driver_name,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
					            </div>
					        </div>
					        <div class="col-xs-12 col-sm-6 col-md-6">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('driver_name', 'Driver Name',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::text('driver_name', $job_disp_data->driver_name,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
					            </div>
					        </div>
					        <div class="col-xs-12 col-sm-6 col-md-6">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('driver_office', 'Driver Office',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::select('driver_office', $office_name_arr,$job_disp_data->driver_office_id,['class'=>'form-control form-control-sm col-sm-8 dynamic-office','data-req-type'=>'driver','disabled'=>'disabled']) }} 
					            </div>
					        </div>
					        <div class="col-xs-12 col-sm-6 col-md-6">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('time_out_d', 'Time Out',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::text('time_out_d', (!empty($time_out_date) ? date('d/m/Y',strtotime($time_out_date)) : ''),array('class'=>'form-control form-control-sm col-sm-5','readonly'=>'readonly')) }} 
					                {{ Form::text('time_out_t', substr($time_out_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-3','readonly'=>'readonly')) }}
					            </div>
					        </div>
					        <div class="col-xs-12 col-sm-6 col-md-6">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('driver_code', 'Driver Code',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::select('driver_code', ['' => ''], '',['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
					            </div>
					        </div>
					        <div class="col-xs-12 col-sm-6 col-md-6">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('time_in_d', 'Time In',['class'=>'col-sm-4 text-right']) }}
	                				{{ Form::text('time_in_d', (!empty($time_in_date) ? date('d/m/Y',strtotime($time_in_date)) : ''),array('class'=>'form-control form-control-sm col-sm-5','readonly'=>'readonly')) }}
	                				{{ Form::text('time_in_t', substr($time_in_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-3','readonly'=>'readonly')) }}
					            </div>
					        </div>
				    	</div>
	        		</div>
	        	</div>
			</div>

	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('voucher_status', 'Voucher Status',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::select('voucher_status', $voucher_status,((empty($job_disp_data->vc_status))?'Invoice':$job_disp_data->vc_status),['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
	            </div>
	        </div>
	        
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('commission_rate', 'Commission Rate',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('commission_rate', $job_disp_data->driver_comm_rate,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	            	{{ Form::label('mile_out', 'Mileage Start',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::number('mile_out', $job_disp_data->vh_mile_out,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	            	{{ Form::label('invoice_date', 'Invoice Date',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('invoice_date', (!empty($job_disp_data->vc_date) ? date('d/m/Y',strtotime($job_disp_data->vc_date)) : ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('trip_amt', 'Trip Amt.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('trip_amt', $job_disp_data->trip_amount,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('mile_in', 'Mileage End',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::number('mile_in', $job_disp_data->vh_mile_in,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('voucher_hours', 'Usage Hours',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('voucher_hours', $job_disp_data->vc_total_hour,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('mile_run', 'Mileage Run',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('mile_run', $job_disp_data->vh_mile_run,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('job_voucher_no', 'Voucher No.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('job_voucher_no', $vc_no,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
            	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                	<i class="far fa-file"></i> VC
                </button>
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-file-upload">
                	Attachment Files
                </button>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('Voucher_amt', 'Voucher Amt.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('Voucher_amt', $vc_amt,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
            	<button type="button" class="btn btn-default" data-toggle="" data-target="">
                  <i class="far fa-trash-alt"></i> VC
                </button>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	            </div>
	        </div>
	    </div>
	</div>
</div>
<div class="modal fade" id="modal-lg">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	  	<form action="{{ route('voucher') }}" id="voucher-form" autocomplete="off" method="POST">
		    @csrf
	    <div class="modal-header py-1">
	      <h4 class="modal-title">Voucher Dialog</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4">
				    <div class="form-group row mx-0 mb-2">
				        {{ Form::label('voucher_no', 'Voucher No',['class'=>'col-sm-4 text-right']) }}
				        {{ Form::text('voucher_no', ($job_vc->vc_no ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }} 
				    </div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
				    <div class="form-group row mx-0 mb-2">
				        {{ Form::label('vc_created_date', 'Create Date',['class'=>'col-sm-4 text-right']) }}
				        {{ Form::text('vc_created_date', '',array('class'=>'form-control form-control-sm col-sm-8 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#vc_created_date')) }} 
				    </div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
				    <div class="form-group row mx-0 mb-2">
				        {{ Form::label('vc_created_time', 'Time',['class'=>'col-sm-4 text-right']) }}
				        {{ Form::text('vc_created_time', ($job_vc->vc_time ?? ''),array('class'=>'form-control form-control-sm col-sm-8 timepicker')) }} 
				    </div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
				    <div class="form-group row mx-0 mb-2">
				        {{ Form::label('ref_voucher_no', 'Ref. VC No.',['class'=>'col-sm-4 text-right']) }}
				        {{ Form::text('ref_voucher_no', ($job_vc->ref_voucher_no ?? ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
				    </div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
				    <div class="form-group row mx-0 mb-2">
				        {{ Form::label('ref_vc_amt', 'Ref. VC Amount',['class'=>'col-sm-4 text-right']) }}
				        {{ Form::text('ref_vc_amt', ($job_vc->ref_vc_amt ?? ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
				    </div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
				    <div class="form-group row mx-0 mb-2">
				        {{ Form::label('vc_payment_type', 'Payment Type',['class'=>'col-sm-4 text-right']) }}
				        {{ Form::select('vc_payment_type', array('Cash'=>'Cash','Credit Card'=>'Credit Card','Billing'=>'Billing'),($job_vc->vc_type ?? 'Billing'),['class'=>'form-control form-control-sm col-sm-8']) }}
				    </div>
				</div>
				<div class="col-sm-8 col-md-8">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
						    <div class="form-group row mx-0 mb-2">
						        {{ Form::label('package_no', 'Package No.',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('package_no', ($job_vc->pk_id ?? ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
						    </div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
						    <div class="form-group row mx-0 mb-2">
						        {{ Form::label('package_name', 'Package Name',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('package_name', ($job_vc->pk_name ?? ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
						    </div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
						    <div class="form-group row mx-0 mb-2">
						        {{ Form::label('package_group', 'Package Group',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('package_group', ($job_vc->pk_group ?? ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
						    </div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
						    <div class="form-group row mx-0 mb-2">
						        {{ Form::label('package_disc', 'Package Disc',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('package_disc', ($job_vc->pk_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
						    </div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 text-center">
					<span class="pay_type display-2 font-weight-bold">A</span>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-ride-information">Ride Information</button>
				</div>
			</div>
			<table class="table vc-table m-0">
				<tr>
					<th colspan="3">Expanation</th>
					<th width="13%">Price</th>
					<th width="13%">Discount</th>
					<th width="13%">Amount</th>
				</tr>
				<tr>
					<td>Airport Transfer</td>
					<td><div class="form-group  mb-0 row">{{ Form::label('at_flight_no', 'Flight No.',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('at_flight_no', ($job_vc->hotel_airport_flight_no ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td width="15%"><div class="form-group mb-0 row">{{ Form::label('at_time', 'Time',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('at_time', ($job_vc->hotel_airport_time ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('at_price', ($job_vc->hotel_airport_price ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('at_discount', ($job_vc->hotel_airport_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('at_amount', ($job_vc->hotel_airport_amt ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td>Pickup Airport</td>
					<td><div class="form-group  mb-0 row">{{ Form::label('pa_flight_no', 'Flight No.',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('pa_flight_no', ($job_vc->airport_hotel_flight_no ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td width="15%"><div class="form-group  mb-0 row">{{ Form::label('pa_time', 'Time',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('pa_time', ($job_vc->airport_hotel_time ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('pa_price', ($job_vc->airport_hotel_price ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('pa_discount', ($job_vc->airport_hotel_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('pa_amount', ($job_vc->airport_hotel_amt ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td>Per hour</td>
					<td><div class="form-group mb-0 row">{{ Form::label('ph_start_time', 'Start Time',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('ph_start_time', ($job_vc->per_hour_flight_no ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td width="15%"><div class="form-group mb-0 row">{{ Form::label('ph_to', 'To',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('ph_to', ($job_vc->per_hour_time ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('ph_price', ($job_vc->per_hour_price ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('ph_discount', ($job_vc->per_hour_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('ph_amount', ($job_vc->per_hour_amt ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="3"><div class="form-group mb-0 row">{{ Form::label('other_desc_1', 'Other 1',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('other_desc_1', $job_disp_data->other_description_1,array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('other_price_1', ($job_vc->other_price_1 ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('other_discount_1', ($job_vc->other_discount_1 ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('other_amount_1', ($job_vc->other_amt_1 ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="3"><div class="form-group mb-0 row">{{ Form::label('other_desc_2', 'Other 2',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('other_desc_2', ($job_vc->other_description_2 ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('other_price_2', ($job_vc->other_price_2 ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('other_discount_2', ($job_vc->other_discount_2 ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('other_amount_2', ($job_vc->other_amt_2 ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="3"><div class="form-group mb-0 row">{{ Form::label('other_desc_3', 'Other 3',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('other_desc_3', ($job_vc->other_description_3 ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('other_price_3', ($job_vc->other_price_3 ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('other_discount_3', ($job_vc->other_discount_3 ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('other_amount_3', ($job_vc->other_amt_3 ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="3"><div class="form-group mb-0 row">{{ Form::label('patking_fees', 'Parking Fees',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('patking_fees', ($job_vc->patking_fees ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('patking_fees_price', ($job_vc->patking_fees_price ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('patking_fees_discount', ($job_vc->patking_fees_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('patking_fees_amount', ($job_vc->patking_fees_amount ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="3"><div class="form-group mb-0 row">{{ Form::label('toll_fees', 'Toll Fees',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('toll_fees', ($job_vc->toll_fees ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('toll_fees_price', ($job_vc->toll_fees_price ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('toll_fees_discount', ($job_vc->toll_fees_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('toll_fees_amount', ($job_vc->toll_fees_amount ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="3"><div class="form-group mb-0 row">{{ Form::label('other_misc', 'Other Miscellaneous',['class'=>'col-sm-4 text-right']) }}
						        {{ Form::text('other_misc', ($job_vc->other_misc ?? ''),array('class'=>'form-control form-control-sm col-sm-8')) }}</div> </td>
					<td>{{ Form::text('other_misc_price', ($job_vc->other_misc_price ?? ''),array('class'=>'form-control form-control-sm col-sm-12 price')) }}</td>
					<td>{{ Form::text('other_misc_discount', ($job_vc->other_misc_discount ?? ''),array('class'=>'form-control form-control-sm col-sm-12 discount')) }}</td>
					<td>{{ Form::text('other_misc_amount', ($job_vc->other_misc_amount ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total','readonly'=>'readonly')) }}</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td>{{ Form::label('total_amt', 'Total Amt',['class'=>'text-right']) }}</td>
					<td>{{ Form::text('total_amt', ($job_vc->total_amt ?? '0.00'),array('class'=>'form-control form-control-sm col-sm-12 total_amt','readonly'=>'readonly')) }}</td>
				</tr>
			</table>
			{{ Form::hidden('dispatcher_job_id', $job_disp_data->id) }}
			{{ Form::hidden('dispatcher_voucher_id', ($job_vc->id ?? '')) }}
	    </div>
	    <div class="modal-footer py-1 justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      <button type="submit" id="save-btn"  value="Submit" class="btn btn-primary">Save changes</button>
	    </div>
		</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-file-upload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">File Attachment Dialog</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="job-file-add" autocomplete="off" method="POST">
			{{ Form::hidden('job_disps_id', $job_disp_data->id) }}
			@csrf
			<div class="row mx-0">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group row mx-0 mb-2">
						<input type="file" name="filename" id="filename" />
					</div>
				</div>
			</div>
			<div class="row mx-0">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<button id="file-download" class="btn btn-info btn-sm">Download file</a>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<button id="file-remove" class="btn btn-warning btn-sm">Delete a file</a>
				</div>
			</div>
        </form>
        <table class="table table-bordered mt-2" id="job-file" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>File Name</th>
				</tr>
			</thead>
		</table>
      </div>
      <div class="modal-footer justify-content-between">
      	<button class="btn btn-light" type="reset" data-dismiss="modal" aria-label="Close" >Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-ride-information">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ride Information</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered mt-2" width="100%">
			<thead>
				<tr>
					<th>Information</th>
					<th>Time</th>
				</tr>
			</thead>
			@if (!empty($app_details))
			<tbody>
				@if (isset($app_details['ride_all_status']))
					@foreach ($app_details['ride_all_status'] as $app_data)
					<tr>
						<td>{{$app_data['status_lable']['status']}}</td>
						<td>{{date('d/m/Y H:i',strtotime($app_data['created_at']))}}</td>
					</tr>
					@endforeach
				@endif
				@if (isset($app_details['ride_extra_charges']))
					@foreach ($app_details['ride_extra_charges'] as $extra_key => $extra_data)
						@if (in_array($extra_key,$ride_extra_info) && !empty($extra_data))
						<tr>
							<td>{{$extra_key}}</td>
							<td>{{$extra_data}}</td>
						</tr>
						@endif
					@endforeach
				@endif
			</tbody>
			@endif
		</table>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-print">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Print Dialog</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('downloadPDF') }}" autocomplete="off" method="POST">
          {{ Form::hidden('dispatcher_job_id', $job_disp_data->id) }}
           @csrf
          <button type="submit" name="print_type" value="a4" class="btn btn-default btn-block btn-flat">Job Order Form (A4)</button>
          <button type="submit" name="print_type" value="a5" class="btn btn-default btn-block btn-flat">Job Order Form (A5)</</button>
          <button type="submit" name="print_type" value="job_form" class="btn btn-default btn-block btn-flat">Job Order Form</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@endsection

@section('jsscript')
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-select/JS/dataTables.select.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script>
	var car_no = "{{$job_disp_data->vh_id}}";
	var driver_code = "{{$job_disp_data->driver_id}}";
	
    $('#mile_in').change(function(){
    	$mile_in = $(this).val();
    	$mile_out = $('#mile_out').val();
    	$('#mile_run').val($mile_in-$mile_out);
    });
    $('.dynamic-office').change(function(){
    	if($(this).val()!='') {
    		var req_type = $(this).data('req-type'); 
	    	var _val = $(this).val();
	    	var _token = $('input[name="_token"]').val();
	    	$.ajax({
	    		url:"{{ route('getcardriverdata')}}",
	    		method: "POST",
	    		dataType: "html",
	    		data:{req_type:req_type,value:_val,_token:_token},
	    		success:function(result){
	    			if(req_type == 'car'){
	    				$('#car_no').html(result);
	    				$('#car_no').val(car_no);
	    			}
	    			if(req_type == 'driver'){
	    				$('#driver_code').html(result);
	    				$('#driver_code').val(driver_code);
	    			}
	    		}
	    	})
    	}
    });
    $( document ).ready(function() {
    	$('#mile_in').trigger( "change" );

    	var table = $('#job-file').DataTable({
			paging: false,
			processing: true,
			serverSide: true,
			searching: false,
			info: false,
			ajax:{
				url: "{{ route('getjobfile', $job_disp_data->id) }}",
			},
			select: {
	            style: 'single'
	        },
			columns: [
				{ data: 'id', name: 'id' },
				{ data: 'filename', name: 'filename' },
			],
			columnDefs: [{
			    targets: [ 0 ],
			    visible: false,
			    searchable: false
			}],
		});

    	$('#driver_office').trigger( "change" );
    	$('#car_office').trigger( "change" );
    	$('.price , .discount').focusout(function() {
    		var price = $(this).closest( "tr" ).find('.price').val();
    		var disc = $(this).closest( "tr" ).find('.discount').val();
    		if (disc.indexOf('%') == -1) {
    			var total = (price - disc).toFixed(2);
    		}else{
    			disc = disc.replace('%','');
    			var disc_val = ((price*disc)/100);
    			var total = (price - disc_val).toFixed(2);
    		}
    		
    		$(this).closest( "tr" ).find('.total').val(total);
    		var grand_total = 0;
    		$('.total').each(function(){
    			if ($(this).val() != '') {
    				grand_total += parseFloat($(this).val());	
    			}
    		});
    		$('#total_amt').val(grand_total.toFixed(2));
    	});
    	$('#vc_created_date').datetimepicker({
	        format: 'L',
	        format: 'DD/MM/YYYY',
	        @if (isset($job_vc->vc_date))
	        	defaultDate:"{{$job_vc->vc_date ?? ''}}"
	        @endif
	    });
	    $('.timepicker').timepicker();

	    $('#save-btn').click(function (e) {
	        e.preventDefault();
	        $(this).html('Sending..');
	    
	        $.ajax({
				data: $('#voucher-form').serialize(),
				url: "{{ route('voucher') }}",
				type: "POST",
				dataType: 'html',
				success: function (data) {

				  $('#voucher-form').trigger("reset");
				  $('#modal-lg').modal('hide');
				  location.reload();
				},
				error: function (data) {
				  console.log('Error:', data);
				  $('#save-btn').html('Save Changes');
				}
	      	});
	    });
	    $('#vc_payment_type').change(function(){
	    	if($(this).val() == 'Cash'){
	    		$('.pay_type').html('B');
	    	}else {
	    		$('.pay_type').html('A');
	    	}

	    });

	    $('#filename').change(function() {
	     	$.ajaxSetup({
	            headers: {
	                'X-CSRF-Token': $('meta[name=_token]').attr('content')
	            }
	        });
	        var formData = new FormData(document.getElementById("job-file-add"));

			$.ajax({
				url:"{{ route('savefile') }}",
				method:"POST",
				data: formData,
				dataType:'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success:function(data)
				{
					$('#job-file-add').trigger("reset");
					table.ajax.reload();
				}
			});
		});

		$('#file-download').click(function(e) {
			e.preventDefault();
			var selected_rows = table.rows( {selected: true} ).indexes();
          	var filename = table.cells( selected_rows, 1 ).data().toArray();
          	var url = '{{ asset('jobfileatt') }}' +'/'+ filename;
          	var element = document.createElement('a');
			element.setAttribute('href',url);
			element.setAttribute('download', filename);

			element.style.display = 'none';
			document.body.appendChild(element);

			element.click();

			//document.body.removeChild(element);
		});
		$('#file-remove').click(function(e) {
			e.preventDefault();
			var selected_rows = table.rows( {selected: true} ).indexes();
          	var file_id = table.cells( selected_rows, 0 ).data().toArray();

          	var _token = $('input[name="_token"]').val();
		  	$.ajax({
				url:"{{ route('removefile')}}",
				method: "POST",
				dataType: "html",
				data:{job_file_id:file_id,_token:_token},
				success:function(result){
					table.ajax.reload();
				}
			});
		});
	});
</script>
@endsection

@section('css')
<!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jquery-ui/ui-lightness/jquery-ui-1.10.0.custom.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-select/css/select.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <style type="text/css">
  	textarea {
	   resize: none;
	}
	.vc-table td, .vc-table th{
		padding: .25rem;
	}
  </style>
@endsection