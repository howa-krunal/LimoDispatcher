@extends('layouts.admin')
@section('content')

<div class="card">
	<div class="card-header py-1">
    	<h3 class="card-title">Add Job</h3>
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
		   
		<form id="dispatcher-form" action="{{ route('dispatcher.store') }}" method="POST"  autocomplete="off">
		    @csrf
		    {{ Form::hidden('ref_job_id',$ref_job_id) }}
		    @if (sizeof($selected_office)>1)
			<div class="row mx-0">
				<div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row">
		                {{ Form::label('branch', 'Branch',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('branch', $branch_name_arr, $default_office_id,['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
	                </div>
		        </div>
			</div>
		    @endif
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
		                {{ Form::text('service_time', '',array('class'=>'form-control form-control-sm col-sm-8 timepicker')) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('referance_no', 'Referance No.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('referance_no', '',['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('car_class', 'Car Class',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('car_class', $car_class_arr,'',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('booking_date', 'Booking',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('booking_date', '',array('class'=>'form-control form-control-sm col-sm-5 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#booking_date')) }}
		                {{ Form::text('booking_time', '',array('class'=>'form-control form-control-sm col-sm-3 timepicker')) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('group_name', 'Group Name',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('group_name', $group_name,'',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('service_type', 'Service Type',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('service_type',$service_type,'',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('other_desc', 'Other Desc.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('other_desc', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('req_vc_no', 'Req. Vc. No.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('req_vc_no', '',['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('guest_name', 'Guest Name',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('guest_name', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('flight_detail', 'Flight Detail',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('flight_detail', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('req_price', 'Req. Price',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('req_price', '',['class'=>'form-control form-control-sm col-sm-8','disabled'=>'disabled']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('room_no', 'Room No.',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('room_no', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('company', 'Company',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('company', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('request_by', 'Request By',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('request_by', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('job_status', 'Job Status',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('job_status',$job_status,'',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('car_office', 'Car Office',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('car_office', $office_name_arr, $default_office_id,['class'=>'form-control form-control-sm col-sm-7 search_select_box dynamic-office','data-req-type'=>'car']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		        	<div class="form-group row mx-0 mb-2">
		            	{{ Form::label('plate_no', 'Plate No.',['class'=>'col-sm-4 text-right']) }}
						{{ Form::text('plate_no', '',['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	                </div>
		        </div>
		        <div class="col-lg-12 px-0">
		        	<div class="row mx-0">
		        		<div class="col-sm-4 px-0">
		        			<div class="col-xs-12 col-sm-12 col-md-12">
					            <div class="form-group row mx-0 mb-2">
					                {{ Form::label('job_remark', 'Job Remark',['class'=>'col-sm-4 text-right']) }}
					                {{ Form::textarea('job_remark', '',['rows'=>'6','class'=>'form-control form-control-sm col-sm-8'] )}} 
					            </div>
					        </div>
		        		</div>
		        		<div class="col-sm-8 px-0">
		        			<div class="row mx-0">
			        			<div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('car_no', 'Car No',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::select('car_no', ['' => ''],'',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('driver_name', 'Driver Name',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::text('driver_name', '',['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('driver_office', 'Driver Office',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::select('driver_office', $office_name_arr,$default_office_id,['class'=>'form-control form-control-sm col-sm-7 search_select_box dynamic-office','data-req-type'=>'driver']) }} 
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('time_out_d', 'Time Out',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::text('time_out_d', '',array('class'=>'form-control form-control-sm col-sm-5 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#time_out_d')) }}
						                {{ Form::text('time_out_t', '',array('class'=>'form-control form-control-sm col-sm-3 timepicker')) }} 
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('driver_code', 'Driver Code',['class'=>'col-sm-4 text-right']) }}
						                {{ Form::select('driver_code', ['' => ''], '',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
						            </div>
						        </div>
						        <div class="col-xs-12 col-sm-6 col-md-6">
						            <div class="form-group row mx-0 mb-2">
						                {{ Form::label('time_in_d', 'Time In',['class'=>'col-sm-4 text-right']) }}
		                				{{ Form::text('time_in_d', '',array('class'=>'form-control form-control-sm col-sm-5 datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#time_in_d')) }}
		                				{{ Form::text('time_in_t', '',array('class'=>'form-control form-control-sm col-sm-3 timepicker')) }}
						            </div>
						        </div>
					    	</div>
		        		</div>
		        	</div>
				</div>

		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('voucher_status', 'Voucher Status',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('voucher_status', $voucher_status,'Pending',['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('commission_rate', 'Commission Rate',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('commission_rate', '',['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		            	{{ Form::label('mile_out', 'Mileage Start',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::number('mile_out', '',['class'=>'form-control form-control-sm col-sm-8']) }}
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
		                {{ Form::text('trip_amt', '',['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('mile_in', 'Mileage End',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::number('mile_in', '',['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('voucher_hours', 'Usage Hours',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('voucher_hours', '',['class'=>'form-control form-control-sm col-sm-8']) }}
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		            </div>
		        </div><div class="col-xs-12 col-sm-4 col-md-4">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('mile_run', 'Mile Run',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('mile_run', '',['class'=>'form-control form-control-sm col-sm-8']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		                <button type="submit" class="btn btn-primary">Submit</button>
		        </div>
		    </div>
		    <div class="modal fade" id="modal-location">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Select Location</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row mx-0">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="form-group row mx-0 mb-2">
										{{ Form::label('pickup_location', 'Pickup Location',['class'=>'col-sm-4 text-right']) }}
										{{ Form::text('pickup_location','',['class'=>'form-control form-control-sm col-sm-8']) }} 
										{{ Form::hidden('pickup_lat','',['id'=>'pickup_lat']) }}
										{{ Form::hidden('pickup_lng','',['id'=>'pickup_lng']) }}
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="form-group row mx-0 mb-2">
										{{ Form::label('drop_location', 'Drop Off Location',['class'=>'col-sm-4 text-right']) }}
										{{ Form::text('drop_location','',['class'=>'form-control form-control-sm col-sm-8']) }}
										{{ Form::hidden('drop_lat','',['id'=>'drop_lat']) }}
										{{ Form::hidden('drop_lng','',['id'=>'drop_lng']) }}
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer py-1 justify-content-between">
					      <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
					    </div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- The Dialog Box requires elements with class "dialog" "titlebar" and "content" for styling and selection.
If you add buttons you need additional elements with class "buttonpane" and "buttonset".
width and height are optional.
-->
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCP1qRVL6dHuek6Fr5wHd8nluegHtOvOTI&libraries=places"></script>
<script>
	var car_no = "";
	var driver_code = "";
	$('#service_date, #invoice_date, #booking_date, #time_out_d, #time_in_d').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY'
    });
    $('#queue_last_date').datetimepicker({
        format: 'DD/MM/YYYY HH:mm',
        icons: {
                time: 'fas fa-clock',
        },
    });
    /*$('#service_time').datetimepicker({
        format: 'LT',
        format: 'HH:mm'
    });*/
    $('.timepicker').timepicker();
    $('.search_select_box').select2({
      	theme: 'bootstrap4',
      	placeholder: ""
		
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
	    	});
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
    $('#service_type').change(function(){
    	if ($(this).val() != 'ROUND-TRIP') {
    		$('#modal-location').modal('show');
    	}
    });
    $( document ).ready(function() {
    	getDistance();
    	$('.dynamic-office').trigger( "change" );
    	
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
		    	form.submit();
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
<script>
	var options = {
	  componentRestrictions: {country: 'th'}
	};
	var pickup_input = document.getElementById('pickup_location');
	var pickup_autocomplete = new google.maps.places.Autocomplete(pickup_input,options);
	pickup_autocomplete.addListener('place_changed', function() {
		var pickup_place = pickup_autocomplete.getPlace();
		console.log(pickup_place.geometry.location);
		$('#pickup_lat').val(pickup_place.geometry.location.lat());
		$('#pickup_lng').val(pickup_place.geometry.location.lng());
		//document.getElementById('pickup_lat').value = ;
		//document.getElementById('pickup_lng').value = pickup_place.geometry.location.lng();
	});
	var drop_input = document.getElementById('drop_location');
	var drop_autocomplete = new google.maps.places.Autocomplete(drop_input,options);
	drop_autocomplete.addListener('place_changed', function() {
		var drop_place = drop_autocomplete.getPlace();
		document.getElementById('drop_lat').value = drop_place.geometry.location.lat();
		document.getElementById('drop_lng').value = drop_place.geometry.location.lng();
	});

function getDistance(){
	var origin1 = {lat: 13.745097, lng: 100.5413472};
	var destinationA = {lat: 13.6899991, lng: 100.7501124};
	var service = new google.maps.DistanceMatrixService;
        service.getDistanceMatrix({
          origins: [origin1],
          destinations: [destinationA],
          travelMode: 'DRIVING',
          unitSystem: google.maps.UnitSystem.METRIC,
          avoidHighways: false,
          avoidTolls: false
        }, function(response, status) {
          if (status !== 'OK') {
            alert('Error was: ' + status);
          } else {
            var originList = response.originAddresses;
            var destinationList = response.destinationAddresses;
            var results = response.rows[0].elements;
            console.log(results[0].distance.text);
            
          }
        });
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
	.pac-container{
		z-index: 9999 !important;
	}
  </style>
@endsection