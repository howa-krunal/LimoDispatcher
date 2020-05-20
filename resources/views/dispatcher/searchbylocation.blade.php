@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header py-1">
    <h3 class="card-title">Today list</h3>
    <!-- <div class="float-right">
      <a class="btn btn-success" href="{{ route('dispatcher.create') }}"> Add</a>
    </div> -->
  </div>
  <!-- /.card-header -->
  <div class="card-body overflow-auto py-2">
    <div class="">
      <form action="{{ route('searchbylocation') }}" id="search-job-form" method="POST" autocomplete="off">
          @csrf
          <table class="searchbox">
            <tr>
              <td valign="center">
                  {{ Form::label('service_type', 'Service Type',['class'=>'']) }}
              </td>
              <td valign="center">
                  {{ Form::select('service_type', $service_type,(isset($search_data['service_type']) ? $search_data['service_type'] : ''),['class'=>'']) }}
              </td>
              <td valign="center">
                  {{ Form::label('desc', 'Desc.',['class'=>'']) }}
              </td>
              <td valign="center">
                  {{ Form::text('desc', (isset($search_data['desc']) ? $search_data['desc'] : ''),array('class'=>'')) }}
              </td>
              <td valign="center">
                  {{ Form::label('require_date', 'Require Date',['class'=>'']) }}
              </td>
              <td valign="center">
                  {{ Form::text('require_date','',array('class'=>' datetimepicker-input','data-toggle'=>'datetimepicker','data-target'=>'#require_date')) }} 
              </td>
              <td valign="center">
                  {{ Form::label('require_time', 'Require Time',['class'=>'']) }}
              </td>
              <td valign="center">
                  {{ Form::text('require_time', (isset($search_data['require_time']) ? $search_data['require_time'] : '') ,array('class'=>'timepicker')) }} 
              </td>
              <td>
                <button type="submit" class="btn btn-primary px-2 py-1">Search Now</button>
              </td>
            </tr>
          </table>
      </form>
    </div>
    <table id="dispatcher-table" class="mt-2 display table table-bordered table-hover">
      <thead>
      <tr>
        <th>OF</th>
        <th>S.Date</th>
        <th>S.Time</th>
        <th>Group</th>
        <th>Service Type</th>
        <th>Other Desc.</th>
        <th>Car Class</th>
        <th>Plate</th>
        <th>Driver Name</th>
        <th>Job Status</th>
        <th>VC No.</th>
        <th>Room</th>
        <th>Guest Name</th>
        <th>S.Amt.</th>
        <th>Flight</th>
        <th>T-Out</th>
        <th>T-In</th>
        <th>M-Out</th>
        <th>M-In</th>
        <th>M-Run</th>
        <th>Cancel</th>
        <th>VC.Status</th>
        <th>Create Date</th>
        <th>Booking No.</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($job_list as $job)
        <tr data-show-action="{{ route('showCarDriver',$job->id) }}" data-disp-id="{{ $job->id }}">
            <td>{{ $job->short_name }}</td>
            <td>{{ date("d/m/Y", strtotime($job->job_date)) }}</td>
            <td>{{ $job->job_time }}</td>
            <td>{{ $job->group_name }}</td>
            <td class="{{ $job_type[$job->service_type] }}">{{ $job->service_type }}</td>
            <td>{{ $job->other_desc }}</td>
            <td>{{ $job->vh_type }}</td>
            <td>{{ $job->vh_no }}</td>
            <td>{{ $job->driver_name }}</td>
            <td>{{ $job->job_status }}</td>
            <td>{{ $job->vh_no }}</td>
            <td>{{ $job->room_no }}</td>
            <td>{{ $job->guest_name }}</td>
            <td>{{ $job->trip_amount }}</td>
            <td>{{ $job->flight_detail }}</td>
            <td>{{ date("H:i", strtotime($job->vh_out_time)) }}</td>
            <td>{{ date("H:i", strtotime($job->vh_in_time)) }}</td>
            <td>{{ $job->vh_mile_out }}</td>
            <td>{{ $job->vh_mile_in }}</td>
            <td>{{ $job->vh_mile_run }}</td>
            <td></td>
            <td>{{ $job->vc_status }}</td>
            <td>{{ date("d/m/Y", strtotime($job->booking_date)) }}</td>
            <td>{{ $job->booking_no }}</td>
            
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
@endsection
@section('jsscript')
<!-- DataTables -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-select/JS/dataTables.select.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script>
  
  $(function () {
    var disp_table = $('#dispatcher-table').DataTable({
      paging: true,
      lengthChange: false,
      searching: false,
      ordering: true,
      info: true,
      autoWidth: false,
      select: {
        style: 'single'
      }
      
    });
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
    $("#search-job-form").validate({
      submitHandler: function(form) {
        // do other things for a valid form
        if($('#require_date').val() == ''){
          toastr.error('Require date  must be filled.');
          $( "#require_date" ).focus();
        } else if($('#require_time').val() == ''){
          toastr.error('Require time  must be filled.');
          $( "#require_time" ).focus();
        } else {
          form.submit();
        }
      }
    });
   /* dom: 'Bfrtip',
      buttons: [{
        text: "Add",
        action: function( e, dt, node, config ) {
          var rows = dt.rows( {selected: true} ).indexes();
          var data = dt.cells( rows, 0 ).data();
        }
      }]*/

    $('#dispatcher-table tbody').on('dblclick', 'tr', function () {
        window.location.href = $(this).data('show-action');
        //alert( 'You clicked on '+$(this).data('dc-action')+'\'s row' );
    });
    $('#require_date').datetimepicker({
        format: 'L',
        format: 'DD/MM/YYYY',
        @if (isset($search_data['require_date']))
          defaultDate:"{{ date('Y-m-d',strtotime(str_replace('/', '-', $search_data['require_date'] ))) }}",
        @endif
    });
    $('.timepicker').timepicker();
  });
</script>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/jquery-ui/ui-lightness/jquery-ui-1.10.0.custom.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-select/css/select.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/jquery-ui-timepicker/jquery.ui.timepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
  <style type="text/css">
    textarea {
     resize: none;
  }
  #dispatcher-table th, #dispatcher-table td {
    padding: .25rem;
  }
  #dispatcher-table {
    font-family: Roboto,Arial,sans-serif;
  }
  #dispatcher-table th{
    overflow-x: hidden;
    white-space: nowrap;
    text-align: center;
  }
  #dispatcher-table td{
    font-size: 12px;
    overflow-x: hidden;
    white-space: nowrap;
  }
  .bg-color-orange {
    background: #f16e23;
  }
  .bg-color-yellow {
    background: #fde23e;
  }
  .searchbox{
    font-size: 12px;
  }
  </style>
@endsection