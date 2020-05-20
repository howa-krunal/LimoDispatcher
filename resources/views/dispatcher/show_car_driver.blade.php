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
@endphp
<div class="card">
	<div class="card-header py-1">
    	<h3 class="card-title">View Job</h3>
    	<div class="float-right">
      		<a class="btn btn-secondary px-2 py-1" href="{{ route('searchbylocation') }}"> Back</a>
    	</div>
	</div>
	<div class="card-body overflow-auto p-1">
	    @csrf
	    <div class="row mx-0">
	    	<div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('booking_no', 'Booking No.',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('booking_no',  $job_disp_data->booking_no,array('class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly')) }} 
	            </div>
	        </div>
	        <div class="col-xs-12 col-sm-8 col-md-8">
	            <div class="form-group row mx-0 mb-2">
	                {{ Form::label('create_date', 'Create Date',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('create_date', date('d/m/Y',strtotime($job_disp_data->created_at)),array('class'=>'form-control form-control-sm col-sm-5','readonly'=>'readonly')) }} 
	                {{ Form::text('create_time', date('H:i',strtotime($job_disp_data->created_at)) ,array('class'=>'form-control form-control-sm col-sm-3','readonly'=>'readonly')) }}
	            </div>
	        </div>
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
	            
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	        	<div class="form-group row mx-0 mb-2">
	            	{{ Form::label('job_remark', 'Job Remark',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::textarea('job_remark', $job_disp_data->job_remark,['rows'=>'6','class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly'] )}}
                </div>
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            
	        </div>
			<div class="col-xs-12 col-sm-4 col-md-4">
	            
	        </div>
	        <div class="col-xs-12 col-sm-4 col-md-4">
	            <div class="form-group row mx-0 mb-2">
	            	{{ Form::label('Voucher_amt', 'Service Amount',['class'=>'col-sm-4 text-right']) }}
	                {{ Form::text('Voucher_amt', $vc_amt,['class'=>'form-control form-control-sm col-sm-8','readonly'=>'readonly']) }}
	            </div>
	        </div>
	    </div>
	    <div class="row mx-0 justify-content-end">
	    	<div class="col-4">
	    		<table width="100%" class=" border">
			    	<tr>
			    		<td colspan="2" align="center"><span class="info-title">Location / Car / Driver Information</span></td>
			    	</tr>
			    	<tr>
			    		<td>
			    			{{ Form::label('time_out', 'Time Out',['class'=>'col-sm-12 text-right']) }}
			    		</td>
			    		<td>
			    			<div class="form-group row mx-0 mb-2">
				    			{{ Form::text('booking_date', date('d/m/Y',strtotime($job_disp_data->job_date)) ,array('class'=>'form-control form-control-sm col-sm-8')) }}
					            {{ Form::text('booking_time', substr($job_disp_data->job_time, 0, -3),array('class'=>'form-control form-control-sm col-sm-4')) }}
				            </div>
				        </td>
			    	</tr>
			    	<tr>
			    		<td>
			    			{{ Form::label('plate_no', 'Plate No.',['class'=>'col-sm-12 text-right']) }}
			    		</td>
			    		<td>
			    			{{ Form::text('plate_no', $job_disp_data->vh_no ,['class'=>'form-control form-control-sm col-sm-12','readonly'=>'readonly']) }}
				        </td>
			    	</tr>
			    	<tr>
			    		<td>
			    			{{ Form::label('car_class', 'Car Model',['class'=>'col-sm-12 text-right']) }}
			                
			    		</td>
			    		<td>
			    			{{ Form::select('car_class', $car_class_arr,$job_disp_data->vh_type_id,['class'=>'form-control form-control-sm col-sm-12','disabled'=>'disabled']) }} 
				        </td>
			    	</tr>
			    	<tr>
			    		<td>
			    			{{ Form::label('driver_name', 'Driver Name',['class'=>'col-sm-12 text-right']) }}
			    		</td>
			    		<td>
			    			{{ Form::text('driver_name', $job_disp_data->driver_name,['class'=>'form-control form-control-sm col-sm-12','readonly'=>'readonly']) }}
				        </td>
			    	</tr>
			    	<tr>
			    		<td>
			    			{{ Form::label('dispatcher_name', 'Dispatcher Name',['class'=>'col-sm-12 text-right']) }}
			    		</td>
			    		<td>
			    			{{ Form::text('dispatcher_name', $job_disp_data->created_by_name,['class'=>'form-control form-control-sm col-sm-12','readonly'=>'readonly']) }}
				        </td>
			    	</tr>
			    </table>
	    	</div>
	    </div>
	    
	</div>
</div>
@endsection

@section('jsscript')
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.js')}}"></script>
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
	});
</script>
@endsection

@section('css')
<!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jquery-ui/ui-lightness/jquery-ui-1.10.0.custom.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.css')}}">
  <style type="text/css">
  	textarea {
	   resize: none;
	}
	.vc-table td, .vc-table th{
		padding: .25rem;
	}
	.info-title {
	    border: 1px solid #000;
	    border-radius: 10px;
	    padding: 10px 5px;
	    background: #94adf5;
	    top: -15px;
	    color: #fff;
	    font-size: 16px;
	    position: relative;

	}
  </style>
@endsection