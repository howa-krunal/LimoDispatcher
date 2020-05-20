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
@endphp
<div class="card">
	<div class="card-header py-1">
    	<h3 class="card-title">Edit Job</h3>
    	<div class="float-right">
      		<a class="btn btn-primary px-2 py-1" href="{{ route('dispatcher.index') }}"> Back</a>
    	</div>
	</div>
	<div class="card-body overflow-auto p-1">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <strong>Whoops!</strong> There were some problems with your input.<br><br>
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		
		<form id="dispatcher-form" action="{{ route('dispatcher.update',$job_disp_data->id) }}" autocomplete="off" method="POST">
		    @csrf
		 	@method('PUT')
		     <div class="row mx-0">
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('service_date', 'Service Date',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('service_date', '',array('class'=>'form-control form-control-sm col-sm-8 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#service_date')) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('service_time', 'Service Time',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('service_time', substr($job_disp_data->job_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-8 timepicker')) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('referance_no', 'Referance No.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('referance_no', $job_disp_data->referance_no,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('car_class', 'Car Class',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('car_class', $car_class_arr,$job_disp_data->vh_type_id,['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('booking_date', 'Booking',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('booking_date', '',array('class'=>'form-control form-control-sm col-sm-5 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#booking_date')) }} 
		                {{ Form::text('booking_time', substr($booking_time, 0, -3) ,array('class'=>'form-control form-control-sm col-sm-3 timepicker')) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('group_name', 'Group Name',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('group_name', $group_name,$job_disp_data->group_name,['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('service_type', 'Service Type',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('service_type',$service_type,$job_disp_data->service_type,['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('other_desc', 'Other Desc.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('other_desc', $job_disp_data->other_desc,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('req_vc_no', 'Req. Vc. No.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('req_vc_no', $job_disp_data->req_vc_no,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('guest_name', 'Guest Name',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('guest_name', $job_disp_data->guest_name,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('flight_detail', 'Flight Detail',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('flight_detail', $job_disp_data->flight_detail,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('req_price', 'Req. Price',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('req_price', $job_disp_data->req_price,['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('room_no', 'Room No.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('room_no', $job_disp_data->room_no,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('company', 'Company',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('company', $job_disp_data->company,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('request_by', 'Request By',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('request_by', $job_disp_data->req_by_emp_name,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('job_status', 'Job Status',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('job_status',$job_status,$job_disp_data->job_status,['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('car_office', 'Car Office',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('car_office', $office_name_arr, $job_disp_data->vh_office_id,['class'=>'form-control form-control-sm col-sm-7 search_select_box dynamic-office','data-req-type'=>'car']) }} 
		                {{ Form::hidden('old_car_office',$job_disp_data->vh_office_id ) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		        	<div class="form-group row mx-0 mb-2">
		            	{{ Form::label('plate_no', 'Plate No.',['class'=>'col-sm-4 text-right']) }}
						{{ Form::text('plate_no', $job_disp_data->vh_no ,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
						{{ Form::hidden('old_plate_no',$job_disp_data->vh_no ) }}
	                </div>
		        </div>
		        <div class="col-lg-12 px-0">
		        	<div class="row mx-0">
		        		<div class="col-sm-4 px-0">
		        			<div class="col-xs-12 col-sm-12 col-md-12">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('job_remark', 'Job Remark',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::textarea('job_remark', $job_disp_data->job_remark,['rows'=>'6','class'=>'form-control form-control-sm col-sm-8'] )}} 
					            </div>
					        </div>
		        		</div>
		        		<div class="col-sm-8 px-0">
		        			<div class="row mx-0">
			        			<div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('car_no', 'Car No',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::select('car_no', ['' => ''],'',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
						                {{ Form::hidden('old_car_no',$job_disp_data->vh_id ) }}
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('driver_name', 'Driver Name',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::text('driver_name', $job_disp_data->driver_name,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
						                {{ Form::hidden('old_driver_name',$job_disp_data->driver_name ) }}
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('driver_office', 'Driver Office',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::select('driver_office', $office_name_arr,$job_disp_data->driver_office_id,['class'=>'form-control form-control-sm col-sm-7 search_select_box dynamic-office','data-req-type'=>'driver']) }} 
						                {{ Form::hidden('old_driver_office',$job_disp_data->driver_office_id ) }}
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('time_out_d', 'Time Out',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::text('time_out_d', '',array('class'=>'form-control form-control-sm col-sm-5 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#time_out_d')) }} 
						                {{ Form::text('time_out_t', substr($time_out_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-3 timepicker')) }}
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('driver_code', 'Driver Code',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::select('driver_code', ['' => ''], '',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
						                {{ Form::hidden('old_driver_code',$job_disp_data->driver_id ,array('id'=>'old_driver_code')) }}
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('time_in_d', 'Time In',['class'=>'col-sm-4 text-right']) }}
		                				{{ Form::text('time_in_d', '',array('class'=>'form-control form-control-sm col-sm-5 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#time_in_d')) }}
		                				{{ Form::text('time_in_t', substr($time_in_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-3 timepicker')) }}
						            </div>
						        </div>
					    	</div>
		        		</div>
		        	</div>
				</div>

		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('voucher_status', 'Voucher Status',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('voucher_status', $voucher_status,((empty($job_disp_data->vc_status))?'Pending':$job_disp_data->vc_status),['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('commission_rate', 'Commission Rate',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('commission_rate', $job_disp_data->driver_comm_rate,['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		            	{{ Form::label('mile_out', 'Mileage Start',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::number('mile_out', $job_disp_data->vh_mile_out,['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		            	{{ Form::label('invoice_date', 'Invoice Date',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('invoice_date', '',array('class'=>'form-control form-control-sm col-sm-8 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#invoice_date')) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('trip_amt', 'Trip Amt.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('trip_amt', $job_disp_data->trip_amount,['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('mile_in', 'Mileage End',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::number('mile_in', $job_disp_data->vh_mile_in,['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('voucher_hours', 'Usage Hours',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('voucher_hours', $job_disp_data->vc_total_hour,['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		            </div>
		        </div><div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('mile_run', 'Mileage Run',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('mile_run', $job_disp_data->vh_mile_run,['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		                <button type="submit" class="btn btn-primary">Submit</button>
		        </div>
		    </div>
		    <div class="modal fade" id="modal-change-driver">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Select driver change option</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							{{ Form::label('pickup_location', 'Select reinsert option for changed driver.') }}
						</div>										
						<div class="modal-footer py-1 justify-content-between">
					      <button type="button" class="btn btn-primary driver-opt" id="opt_1">Add top in the queue</button>
					      <button type="button" class="btn btn-primary driver-opt" id="opt_2">Add last in queue</button>
					      <button type="button" class="btn btn-primary driver-opt" id="opt_3">Skip</button>
					    </div>
					</div>
				</div>
			</div>
			{{ Form::hidden('changed_driver_option','opt_3') }}
		</form>
	</div>
</div>
<div id="dialog" class="dialog" style="min-width:450px; min-height:250px;">
	<div class="titlebar">Driver & Car Queue</div>
	<button name="close"><!-- enter symbol here like &times; or &#x1f6c8; or use the default X if empty --></button>
	<div class="content">
		<div class="row">
			<div class="col-sm-1">
				<a href="#" data-toggle="modal" data-target="#modal-auto-queue" role="button" class="btn btn-light btn-sm"><i class="fas fa-plus"></i></a>
				<a href="#" id="auto-queue-reload" role="button" class="btn btn-light btn-sm mt-2"><i class="fas fa-redo"></i></a>
				<a href="#" id="auto-queue-remove" role="button" class="btn btn-light btn-sm mt-2"><i class="fas fa-trash-alt"></i></a>
			</div>
			<div class="col-sm-11">
				<table class="table table-bordered" id="job-driver-queue">
					<thead>
						<tr>
							<th>Id</th>
							<th>Driver office Id</th>
							<th>Driver Id</th>
							<th>Auto office Id</th>
							<th>Auto Id</th>
							<th>@</th>
							<th>Driver</th>
							<th>Last Date</th>
							<th>@</th>
							<th>Car No.</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<!-- <div class="buttonpane">
		<div class="buttonset">
			<button name="ok">OK</button>
			<button name="cancel">Cancel</button>
		</div>
	</div> -->
</div>
<div class="modal fade" id="modal-auto-queue">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Driver & Car Dialog</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="auto-queue-add" autocomplete="off" method="POST">
			{{ Form::hidden('dispatcher_job_id') }}
			@csrf
			<div class="row mx-0">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group row mx-0 mb-2">
						{{ Form::label('queue_driver_office', 'Driver Office',['class'=>'col-sm-3 text-right']) }}
						{{ Form::select('queue_driver_office', $office_name_arr,$default_office_id,['class'=>'form-control form-control-sm col-sm-8 search_select_box dynamic-office','data-req-type'=>'queue-driver']) }} 
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="form-group row mx-0 mb-2">
		            	<div class="col-sm-3 text-right">
		            		{{ Form::label('queue_driver_code', 'Driver Code',['class'=>'']) }}
		            	</div>
		                <div class="col-sm-5 px-0">
		                	{{ Form::select('queue_driver_code', ['' => ''], '',['class'=>'form-control form-control-sm search_select_box']) }}
		                </div>
		                <div class="col-sm-4">
		                	{{ Form::text('queue_driver_name', '',['class'=>'form-control form-control-sm','id'=>'queue_driver_name']) }}
		                </div>
		                 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('queue_last_date', 'Last Date',['class'=>'col-sm-3 text-right']) }}
		                {{ Form::text('queue_last_date', '',array('class'=>'form-control form-control-sm col-sm-6 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#queue_last_date')) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('queue_car_office', 'Car Office',['class'=>'col-sm-3 text-right']) }}
		                {{ Form::select('queue_car_office', $office_name_arr, $default_office_id,['class'=>'form-control form-control-sm col-sm-8 search_select_box dynamic-office','data-req-type'=>'queue-car']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-12">
		            <div class="form-group row mx-0 mb-2">
		            	<div class="col-sm-3 text-right">
		                	{{ Form::label('queue_car_no', 'Car No',['class'=>'']) }}
		                </div>
		                <div class="col-sm-5 px-0">
		                	{{ Form::select('queue_car_no', ['' => ''],'',['class'=>'form-control form-control-sm search_select_box']) }} 
		                </div>
		                <div class="col-sm-4">
		                	{{ Form::text('queue_plate_no', '',['class'=>'form-control form-control-sm','id'=>'queue_plate_no']) }}
		                </div>
		            </div>
		        </div>
			</div>
			<div class=" row mx-0 mb-2">
		        <div class="col-sm-6 text-right">
		        	<button class="btn btn-primary" type="submit">Save</button>
		        </div>
		        <div class="col-sm-6">
		        	<button class="btn btn-light" type="reset" data-dismiss="modal" aria-label="Close" >Cancel</button>
		        </div>
	    	</div>
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
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('plugins/draggable-dialog/draggable-resizable-dialog.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-select/JS/dataTables.select.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script>
	var car_no = "{{$job_disp_data->vh_id}}";
	var driver_code = "{{$job_disp_data->driver_id}}";
	$('#service_date').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY',
        defaultDate:"{{$job_disp_data->job_date}}"
    });
    $('#invoice_date').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY',
        defaultDate:"{{$job_disp_data->vc_date}}"
    });
    $('#booking_date').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY',
        defaultDate:"{{$booking_date}}"
    }); 
    $('#time_out_d').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY',
        defaultDate:"{{$time_out_date}}"
    }); 
    $('#time_in_d').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY',
        defaultDate:"{{$time_in_date}}"
    });
    $('.timepicker').timepicker();
    $('.search_select_box').select2({
      theme: 'bootstrap4'
  	});
  	$('#queue_last_date').datetimepicker({
        format: 'DD/MM/YYYY HH:mm',
        icons: {
                time: 'fas fa-clock',
        },
    });
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
	    				if(car_no != ''){
	    					$('#car_no').val(car_no).trigger( "change" );
	    				}
	    			}
	    			if(req_type == 'driver'){
	    				$('#driver_code').html(result);
	    				if(driver_code != ''){
	    					$('#driver_code').val(driver_code).trigger( "change" );
	    				}
	    			}
	    			if(req_type == 'queue-driver'){
	    				$('#queue_driver_code').html(result);
	    				
	    			}
	    			if(req_type == 'queue-car'){
	    				$('#queue_car_no').html(result);
	    				
	    			}
	    		}
	    	})
    	}
    });
    $('#car_no').change(function(){
    	var plat_no = $(this).val();
    	if (plat_no != '') {
    		$('#plate_no').val($("#car_no option:selected").html());
    	}
    });
    $('#driver_code').change(function(){
    	var driver_id = $(this).val();
    	if (driver_id != '') {
    		$('#driver_name').val($("#driver_code option:selected").html());
    		$('#commission_rate').val($(this).find(':selected').data('com-rate'));
    	}
    });
	$('#queue_car_no').change(function(){
    	var plat_no = $(this).val();
    	if (plat_no != '') {
    		console.log($("#queue_car_no option:selected").html());
    		$('#queue_plate_no').val($("#queue_car_no option:selected").html());
    	}
    });
    $('#queue_driver_code').change(function(){
    	var driver_id = $(this).val();
    	if (driver_id != '') {
    		console.log($("#queue_driver_code option:selected").html());
    		$('#queue_driver_name').val($("#queue_driver_code option:selected").html());
    	}
    });
    $( document ).ready(function() {
    	$('.dynamic-office').trigger( "change" );
    	$('#mile_in').trigger( "change" );

    	toastr.options = {
		  "closeButton": false,
		  "debug": false,
		  "newestOnTop": false,
		  "progressBar": false,
		  "positionClass": "toast-top-center",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut"
		};
		$("#dispatcher-form").validate({
		  submitHandler: function(form) {
		    // do other things for a valid form
		    if($('#service_date').val() == ''){
				toastr.error('Service date  must be filled.');
				$( "#service_date" ).focus();
		    } else if($('#service_time').val() == ''){
				toastr.error('Service time  must be filled.');
				$( "#service_time" ).focus();
		    } else if($('#service_type').val() == ''){
				toastr.error('Service Type  must be filled.');
				$( "#service_type" ).focus();
		    } else if($('#car_class').val() == ''){
				toastr.error('Car class must be filled.');
				$( "#car_class" ).focus();
		    } else {
		    	if ($('#old_driver_code').val() != '' && $('#old_driver_code').val() != $('#driver_code').val() ) {
		    		$('#modal-change-driver').modal('show');
		    		$('.driver-opt').click(function(){
		    			$('input[name="changed_driver_option"]').val($(this).attr('id'));
		    			form.submit();
		    		});
		    	}else{
					form.submit();		    		
		    	}
		    }
		    
		  }
		});
		showDialog();
    	var table = $('#job-driver-queue').DataTable({
			paging: false,
			processing: true,
			serverSide: true,
			searching: false,
			info: false,
			ajax:{
				url: "{{ route('jobautoqueue.index') }}",
			},
			select: {
	            style: 'single'
	        },
			columns: [
				{ data: 'id', name: 'id' },
				{ data: 'driver_office_id', name: 'driver_office_id' },
				{ data: 'driver_id', name: 'driver_id' },
				{ data: 'vh_office_id', name: 'vh_office_id' },
				{ data: 'vh_id', name: 'vh_id' },
				{ data: 'driver_short_name', name: 'driver_short_name' },
				{ data: 'driver_name', name: 'driver_name' },
				{ data: 'last_date', name: 'last_date' },
				{ data: 'auto_short_name', name: 'auto_short_name' },
				{ data: 'vh_no', name: 'vh_no' }
			],
			columnDefs: [{
			    targets: [ 0 ],
			    visible: false,
			    searchable: false
			},{
			    targets: [ 1 ],
			    visible: false,
			    searchable: false
			},{
			    targets: [ 2 ],
			    visible: false,
			    searchable: false
			},{
			    targets: [ 3 ],
			    visible: false,
			    searchable: false
			},{
			    targets: [ 4 ],
			    visible: false,
			    searchable: false
			}],
		});
		$('#job-driver-queue tbody').on('dblclick','tr',function(e){
		    table.rows(this).select();
		    var selected_rows = table.rows( {selected: true} ).indexes();
          	var queue_id = table.cells( selected_rows, 0 ).data().toArray();
          	var driver_off_id = table.cells( selected_rows, 1 ).data().toArray();
          	driver_code = table.cells( selected_rows, 2 ).data().toArray();
          	var auto_off_id = table.cells( selected_rows, 3 ).data().toArray();
          	car_no = table.cells( selected_rows, 4 ).data().toArray();
			car_no = car_no[0];
          	driver_code = driver_code[0];
          	
          	$('#driver_office').val(driver_off_id[0]).trigger( "change" );
          	$('#car_office').val(auto_off_id[0]).trigger( "change" );

          	removeQueueData(queue_id[0],table);
		});
		$('#auto-queue-reload').click(function() {
			table.ajax.reload();
		});
		$('#auto-queue-remove').click(function() {
			var selected_rows = table.rows( {selected: true} ).indexes();
          	var queue_id = table.cells( selected_rows, 0 ).data().toArray();
          	removeQueueData(queue_id,table);
		});
		$("#auto-queue-add").validate({
		  submitHandler: function(form) {
		    // do other things for a valid form
		    if($('#queue_driver_code').val() == ''){
				toastr.error('Driver code must be filled.');
				$( "#queue_driver_code" ).focus();
		    } else if($('#queue_car_no').val() == ''){
				toastr.error('Car no. must be filled.');
				$( "#queue_car_no" ).focus();
		    } else {
		    	$.ajax({
					url:"{{ route('jobautoqueue.store') }}",
					method: "POST",
					dataType: "html",
					data: $('#auto-queue-add').serialize(),
					success:function(result){
						$("#auto-queue-add").trigger("reset");
						table.ajax.reload();
						$('#modal-auto-queue').modal('hide');
					}
				});
		    }
		  }
		});
	});
	function removeQueueData(queue_id,queue_datatable_ref){
		var _token = $('input[name="_token"]').val();
	  	$.ajax({
			url:"{{ route('removeJobAutoQueue')}}",
			method: "POST",
			dataType: "html",
			data:{auto_queue_id:queue_id,_token:_token},
			success:function(result){
				queue_datatable_ref.ajax.reload();
			}
		});
	}
</script>
<script>
//_showDialogButton = document.getElementById('show-dialog');
//_statusDialog = document.getElementById('dialog-status');
var dialog;
function showDialog() {
	//_statusDialog.textContent = 'Dialog showed...';
	//_showDialogButton.disabled = true;
	if (!dialog) {
		var id = 'dialog';
		// Instanciate the Dialog Box
		dialog = new DialogBox(id);
	}
	// Show Dialog Box
	dialog.showDialog();

	// Receive result from Dialog Box
	/*function callbackDialog(btnName) {
		//_showDialogButton.disabled = false;
		//_showDialogButton.focus();
	}*/
}
</script>
@endsection

@section('css')
<!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jquery-ui/ui-lightness/jquery-ui-1.10.0.custom.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/draggable-dialog/draggable-resizable-dialog.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-select/css/select.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <style type="text/css">
  	textarea {
	   resize: none;
	}
	#job-driver-queue th, #job-driver-queue td {
		padding: .25rem;
	}
	#job-driver-queue {
		font-family: Roboto,Arial,sans-serif;
	}
	#job-driver-queue th{
		overflow-x: hidden;
		white-space: nowrap;
		text-align: center;
	}
	#job-driver-queue td{
		font-size: 12px;
		overflow-x: hidden;
		white-space: nowrap;
		cursor: pointer;
	}
	#modal-auto-queue{
		min-width: 500px;
	}
  </style>
@endsection