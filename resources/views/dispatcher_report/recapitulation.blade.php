@extends('layouts.admin')

@section('content')
<div class="content-header">
	<h2>Recapitulation Report</h2>
</div>
<form action="" id="{{ route('recapitulation') }}" autocomplete="off" method="POST">
@csrf
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Report Condition</h3>

			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i>
				</button>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i>
				</button> -->
			</div>
		</div>
	
		<div class="card-body filter-box">
			<div class="row mx-0">
				<div class="col-xs-12 col-sm-6 col-md-6">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('voucher_date', 'Voucher Date',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::text('voucher_date', $request->voucher_date ,array('class'=>'form-control form-control-sm col-sm-8','id'=>'voucher_date')) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-6 col-md-6">
		            <div class="form-group row mx-0 mb-2">
		                {{ Form::label('group_name', 'Group Name',['class'=>'col-sm-4 text-right']) }}
		                {{ Form::select('group_name', $group_name, $request->group_name ,['class'=>'form-control form-control-sm col-sm-7 search_select_box']) }} 
		            </div>
		        </div>
		        <div class="col-xs-12 col-sm-2 col-md-2 text-right">
		        	{{ Form::label('voucher_status', 'Voucher Status',['class'=>'']) }}
		        </div>
		        <div class="col-xs-12 col-sm-10 col-md-10">
		        	@foreach ($voucher_status as $status)
		        	<div class="form-group float-left ml-2">
						<div class="icheck-primary d-inline">
							@if (isset($request->vcstatus) && in_array($status, $request->vcstatus))
								<input type="checkbox" name="vcstatus[]" value="{{$status}}" id="{{$status}}"  checked="checked"  />
							@else
								<input type="checkbox" name="vcstatus[]" value="{{$status}}" id="{{$status}}" />
							@endif
							
							<label for="{{$status}}"> {{$status}} </label>
						</div>
	                </div>
	                @endforeach
		        </div>
		        <div class="col-xs-12 col-sm-2 col-md-2 text-right">
		        	{{ Form::label('job_type', 'Job Type',['class'=>'']) }}
		        </div>
		        <div class="col-xs-12 col-sm-10 col-md-10">
		        	<div class="form-group float-left ml-2">
						<div class="icheck-primary d-inline">
							@if (isset($request->job_type) && in_array('internal', $request->job_type))
								<input type="checkbox" name="job_type[]" value="internal" id="internal" checked="checked" />
							@else
								<input type="checkbox" name="job_type[]" value="internal" id="internal" />
							@endif
							<label for="internal"> Internal </label>
						</div>
	                </div>
	                <div class="form-group float-left ml-2">
						<div class="icheck-primary d-inline">
							@if (isset($request->job_type) && in_array('external', $request->job_type))
								<input type="checkbox" name="job_type[]" value="external" id="external" checked="checked" />
							@else
								<input type="checkbox" name="job_type[]" value="external" id="external" />
							@endif
							<label for="external"> External </label>
						</div>
	                </div>
		        </div>
		        <div class="col-xs-12 col-sm-2 col-md-2 text-right">
		        	{{ Form::label('used_cancel', 'Used / Cancel',['class'=>'']) }}
		        </div>
		        <div class="col-xs-12 col-sm-10 col-md-10">
		        	<div class="form-group float-left ml-2">
						<div class="icheck-primary d-inline">
							@if (isset($request->cancel) && in_array(0, $request->cancel))
								<input type="checkbox" name="cancel[]" value="0" id="Used"  checked="checked" />
							@else
								<input type="checkbox" name="cancel[]" value="0" id="Used" />
							@endif
							<label for="Used"> Used </label>
						</div>
	                </div>
	                <div class="form-group float-left ml-2">
						<div class="icheck-primary d-inline">
							@if (isset($request->cancel) && in_array(1, $request->cancel))
								<input type="checkbox" name="cancel[]" value="1" id="Cancel" checked="checked" />
							@else
								<input type="checkbox" name="cancel[]" value="1" id="Cancel" />
							@endif
							<label for="Cancel"> Cancel </label>
						</div>
	                </div>
		        </div>
			</div>
		</div>
		<div class="card-footer">
			<div class=" row mx-0 mb-2">
		        <div class="col-sm-6 text-right">
		        	<button class="btn btn-primary" type="submit">Search</button>
		        </div>
		        <div class="col-sm-6">
		        	<button class="btn btn-secondary" type="reset" aria-label="Close" >Rest</button>
		        </div>
			</div>
		</div>
	
	</div>
</form>
@if (!empty($report_data))
<div class="card">
	<div class="card-body overflow-auto py-2">
		<table id="dispatcher-table" class="mt-2 display table table-bordered table-hover">
			<thead>
				<tr>
					<th>VC. NO.</th>
					<th>VC. Date</th>
					<th>Room No.</th>
					<th>Guest Name</th>
					<th>Service Amt.</th>
					<th>VC. Status</th>
					<th>Service Type</th>
					<th>VC. Hour</th>
					<th>Request By</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td>Totals</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
			<tbody>
			@foreach ($report_data as $data)
				<tr>
				    <td>{{ $data->vc_no }}</td>
				    <td>{{ date("d/m/Y", strtotime($data->vc_date)) }}</td>
				    <td>{{ $data->room_no }}</td>
				    <td>{{ $data->guest_name }}</td>
				    <td>{{ $data->total_amt }}</td>
				    <td>{{ $data->vc_status }}</td>
				    <td>{{ $data->service_type }}</td>
				    <td>{{ $data->vc_total_hour }}</td>
				    <td>{{ $data->req_by_emp_name }}</td>
				</tr>
			@endforeach
			</tbody>
	    </table>
	</div>
</div>
<script type="text/javascript">
	
</script>
@endif
@endsection
@section('jsscript')
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-select/JS/dataTables.select.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.flash.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script>
$(function () {
    //Date range picker
    //$('#voucher_date').daterangepicker();
    var disp_table = $('#dispatcher-table').DataTable({
		paging: true,
		lengthChange: false,
		searching: false,
		ordering: true,
		info: true,
		autoWidth: false,
		dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', footer: true, className: 'copyButton' },
            { extend: 'csv', footer: true, className: 'copyButton' },
            { extend: 'excel', footer: true, className: 'copyButton' },
            { extend: 'pdf', footer: true, className: 'copyButton' },
        ],
        footerCallback: function ( row, data, start, end, display ) {
			var api = this.api();
			nb_cols = api.columns().nodes().length;
			var j = 4;
			while(j < nb_cols){
				var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
            	}, 0 );
      		// Update footer
      		$( api.column( j ).footer() ).html(pageTotal);
				j++;
			}
		}
    });
    $('#voucher_date').daterangepicker({
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale: {
	      format: 'DD/MM/YYYY'
	    }
    });
    disp_table.on( 'draw', function () {
		alert(100);
    	$('.filter-box').collapse('toggle');
	});
@if (!empty($report_data))

	
@endif
});

</script>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}" >
<link rel="stylesheet" href="{{asset('plugins/datatables-select/css/select.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection