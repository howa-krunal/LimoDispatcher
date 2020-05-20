@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header py-1">
      <ul class="nav nav-pills ml-auto">
        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Today Job</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Future Job</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">All Job</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Hotel Job</a></li>
      </ul>
  </div>
  <!-- /.card-header -->
  <div class="card-body overflow-auto py-2">
    <div class="tab-content">
      <div class="btn-group">
        <button type="button" class="add-disp-job btn btn-default">ADD</button>
        <button type="button" class="edit-disp-job btn btn-default">EDIT</button>
        <button type="button" class="delete-disp-job btn btn-default">DELETE</button>
        <button type="button" class="print-disp-job btn btn-default">PRINT</button>
      </div>
      <div class="tab-pane active" id="tab_1">
        <table id="today-dispatcher-table" class="mt-2 display table table-bordered table-hover dispatcher-table">
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
            <th>Room</th>
            <th>Guest Name</th>
            <th>S.Amt.</th>
            <th>Flight</th>
            <th>T-Out</th>
            <th>T-In</th>
            <th>M-Out</th>
            <th>M-In</th>
            <th>M-Run</th>
            <th>VC.Status</th>
            <th>Create Date</th>
            <th>Booking No.</th>
          </tr>
          </thead>
        </table>
      </div>
      <div class="tab-pane" id="tab_2">
        <table id="future-dispatcher-table" class="mt-2 display table table-bordered table-hover dispatcher-table">
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
            <th>Room</th>
            <th>Guest Name</th>
            <th>S.Amt.</th>
            <th>Flight</th>
            <th>T-Out</th>
            <th>T-In</th>
            <th>M-Out</th>
            <th>M-In</th>
            <th>M-Run</th>
            <th>VC.Status</th>
            <th>Create Date</th>
            <th>Booking No.</th>
          </tr>
          </thead>
        </table>
      </div>
      <div class="tab-pane" id="tab_3">
        <table id="future-dispatcher-table" class="mt-2 display table table-bordered table-hover dispatcher-table">
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
            <th>Room</th>
            <th>Guest Name</th>
            <th>S.Amt.</th>
            <th>Flight</th>
            <th>T-Out</th>
            <th>T-In</th>
            <th>M-Out</th>
            <th>M-In</th>
            <th>M-Run</th>
            <th>VC.Status</th>
            <th>Create Date</th>
            <th>Booking No.</th>
          </tr>
          </thead>
        </table>
      </div>
      <div class="tab-pane" id="tab_4">
        <table id="future-dispatcher-table" class="mt-2 display table table-bordered table-hover dispatcher-table">
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
            <th>Room</th>
            <th>Guest Name</th>
            <th>S.Amt.</th>
            <th>Flight</th>
            <th>T-Out</th>
            <th>T-In</th>
            <th>M-Out</th>
            <th>M-In</th>
            <th>M-Run</th>
            <th>VC.Status</th>
            <th>Create Date</th>
            <th>Booking No.</th>
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
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
          {{ Form::hidden('dispatcher_job_id') }}
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
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-select/JS/dataTables.select.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<script>
  
  $(function () {
    var datatable_option = {
      paging: true,
      lengthChange: false,
      searching: false,
      ordering: true,
      info: true,
      autoWidth: false,
      
      select: {
        style: 'single'
      },
      columns: [
        { data: 'short_name', name: 'short_name' },
        { data: 'job_date', name: 'job_date' },
        { data: 'job_time', name: 'job_time' },
        { data: 'group_name', name: 'group_name' },
        { data: 'service_type', name: 'service_type' },
        { data: 'other_desc', name: 'other_desc' },
        { data: 'vh_type', name: 'vh_type' },
        { data: 'vh_no', name: 'vh_no' },
        { data: 'driver_name', name: 'driver_name' },
        { data: 'job_status', name: 'job_status' },
        { data: 'room_no', name: 'room_no' },
        { data: 'guest_name', name: 'guest_name' },
        { data: 'trip_amount', name: 'trip_amount' },
        { data: 'flight_detail', name: 'flight_detail' },
        { data: 'vh_out_time', name: 'vh_out_time' },
        { data: 'vh_in_time', name: 'vh_in_time' },
        { data: 'vh_mile_out', name: 'vh_mile_out' },
        { data: 'vh_mile_in', name: 'vh_mile_in' },
        { data: 'vh_mile_run', name: 'vh_mile_run' },
        { data: 'vc_status', name: 'vc_status' },
        { data: 'booking_date', name: 'booking_date' },
        { data: 'booking_no', name: 'booking_no' }
      ],
      createdRow: function( row, data, dataIndex ) {
        // Set the data-status attribute, and add a class
        $(row).attr('data-show-action',data.show_action);
        $(row).attr('data-edit-action',data.edit_action);
        $(row).attr('data-disp-id',data.id);
        if ( data.service_type == 'FROM-AIRPORT' ) {
          $('td', row).eq(4).addClass('bg-color-yellow');
        }else if(data.service_type == 'TO-AIRPORT'){
          $('td', row).eq(4).addClass('bg-color-orange');
        }
      }
      
    };
    var tab_1 = { ajax:{
        url: "{{ route('jobList') }}",
        data:{
        "_token": "{{ csrf_token() }}",
        "id": "tab_1"
        },
        type: "POST"
      }
    };
    var tab_2 = { ajax:{
        url: "{{ route('jobList') }}",
        data:{
        "_token": "{{ csrf_token() }}",
        "id": "tab_2"
        },
        type: "POST"
      }
    };
    var tab_3 = { ajax:{
        url: "{{ route('jobList') }}",
        data:{
        "_token": "{{ csrf_token() }}",
        "id": "tab_3"
        },
        type: "POST"
      }
    };
    var tab_4 = { ajax:{
        url: "{{ route('jobList') }}",
        data:{
        "_token": "{{ csrf_token() }}",
        "id": "tab_4"
        },
        type: "POST"
      }
    };
    
    var disp_table = $('#tab_2 table').DataTable($.extend( datatable_option, tab_2 ));
    var disp_table = $('#tab_3 table').DataTable($.extend( datatable_option, tab_3 ));
    var disp_table = $('#tab_4 table').DataTable($.extend( datatable_option, tab_4 ));
    var disp_table = $('#tab_1 table').DataTable($.extend( datatable_option, tab_1 ));
    
    setInterval( function () {
        disp_table.ajax.reload();
    }, 10000 );
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
   /* dom: 'Bfrtip',
      buttons: [{
        text: "Add",
        action: function( e, dt, node, config ) {
          var rows = dt.rows( {selected: true} ).indexes();
          var data = dt.cells( rows, 0 ).data();
        }
      }]*/

    $('.dispatcher-table tbody').on('dblclick', 'tr', function () {
        disp_table.rows(this).select();
        window.location.href = $(this).data('show-action');
        //alert( 'You clicked on '+$(this).data('dc-action')+'\'s row' );
    });
    $('.add-disp-job').click(function(){
        window.location.href = '{{ route('dispatcher.create') }}';
    });
    $('.edit-disp-job').click(function(){
      var edit_url = $('.tab-content .active .dispatcher-table tbody tr.selected').data('edit-action');
      
      if (edit_url !== undefined) {
        window.location.href = edit_url;
      }else{
        toastr.error('Please select a record to edit');
      }
    });
    $('.delete-disp-job').click(function(){
      if ($('.dispatcher-table tbody tr.selected').find('form').length > 0) {
        $('.dispatcher-table tbody tr.selected').find('form').submit;
      }else{
        toastr.error('Please select a record to delete');
      }
    });
    $('.print-disp-job').click(function(){
      var disp_id = $('.dispatcher-table tbody tr.selected').data('disp-id');
      
      if (disp_id !== undefined) {
        $("[name='dispatcher_job_id']").val(disp_id);
        $('#modal-print').modal('show');
        //window.location.href = print_url;
      }else{
        toastr.error('Please select a record to print');
      }
    });
  });
</script>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables-select/css/select.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
  <style type="text/css">
    textarea {
     resize: none;
  }
  .dispatcher-table th, .dispatcher-table td {
    padding: .25rem;
  }
  .dispatcher-table {
    font-family: Roboto,Arial,sans-serif;
  }
  .dispatcher-table th{
    overflow-x: hidden;
    white-space: nowrap;
    text-align: center;
  }
  .dispatcher-table td{
    font-size: 12px;
    overflow-x: hidden;
    white-space: nowrap;
    cursor: pointer;
  }
  .bg-color-orange {
    background: #f16e23;
  }
  .bg-color-yellow {
    background: #fde23e;
  }
  </style>
@endsection