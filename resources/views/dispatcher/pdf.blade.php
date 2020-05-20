<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style type="text/css">
      body{
        font-family: Tahoma,Lucida Grande, Lucida Sans, Arial, sans-serif;
        font-size: 13px;
      }
      .title{
        font-size: 20px;
        font-weight: 700;
      }
      .title-company{
        font-size: 16px;
      }
      @page { margin: 15px; }
      body { margin: 0px; }
    </style>
  </head>
  <body>
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
      <tr>
        <td width="50%" rowspan="2">
          <table>
            <tr>
              <td><img src="{{public_path('dist/img/howa.png')}}" width="80px" /></td>
              <td>
                <span class="title">JOB ORDER</span><br>
                <span class="title-company">BELL TRANSPORT CO.,LTD.</span> 
              </td>
            </tr>
          </table>
        </td>
        <td width="15%">Booking No. : </td>
        <td width="20%">{{$job_disp_data->booking_no}}</td>
        <td width="15%">{{$job_disp_data->id}}</td>
      </tr>
      <tr>
        <td align="center"> Car Class </td>
        <td align="center" colspan="2"> {{$job_disp_data->vh_type}} </td>
      </tr>
    </table>
    <table width="100%" border="1" cellpadding="5" cellspacing="0"  style="margin-top: 15px;">
      <tr>
        <td width="15%">Service Date :</td>
        <td width="35%">{{date('d/m/Y',strtotime($job_disp_data->job_date))}}</td>
        <td width="15%" rowspan="2">Customer :</td>
        <td width="35%" rowspan="2">{{$job_disp_data->group_name}}</td>
      </tr>
      <tr>
        <td> Service Time :</td>
        <td>{{date('H:i',strtotime($job_disp_data->job_time))}}</td>
      </tr>
      <tr>
        <td>Guest Name :</td>
        <td>{{$job_disp_data->guest_name}}</td>
        <td>Room No. :</td>
        <td>{{$job_disp_data->room_no}}</td>
      </tr>
      <tr>
        <td>Company :</td>
        <td>{{$job_disp_data->company}}</td>
        <td>Flight Details :</td>
        <td>{{$job_disp_data->flight_detail}}</td>
      </tr>
      <tr>
        <td>Service Type :</td>
        <td>{{$job_disp_data->service_type}}</td>
        <td>Date/Time :</td>
        <td>{{date('d/m/Y  H:i',strtotime($job_disp_data->booking_date))}}</td>
      </tr>
      <tr>
        <td>Other Desc. :</td>
        <td>{{$job_disp_data->other_desc}}</td>
        <td>Request by :</td>
        <td>{{$job_disp_data->req_by_emp_name}}</td>
      </tr>
      <tr>
        <td colspan="4"  height="50" valign="top">Remark : {{$job_disp_data->job_remark}}</td>
      </tr>
    </table>
    <table width="100%" border="1" cellpadding="5" cellspacing="0"  style="margin-top: 15px;">
      <tr>
        <td>Car Office :</td>
        <td>{{ isset($office_name_arr[$job_disp_data->driver_office_id]) ? $office_name_arr[$job_disp_data->driver_office_id] : '' }}</td>
        <td>Car Type :</td>
        <td>{{$job_disp_data->vh_type}}</td>
        <td>Plate No. :</td>
        <td>{{$job_disp_data->vh_no}}</td>
      </tr>
      <tr>
        <td>Driver Office :</td>
        <td>{{ isset($office_name_arr[$job_disp_data->vh_office_id]) ? $office_name_arr[$job_disp_data->vh_office_id] : ''  }}</td>
        <td>Driver :</td>
        <td>{{$job_disp_data->driver_name}}</td>
        <td>Driver Mobile :</td>
        <td>{{$job_disp_data->vh_type}}</td>
      </tr>
      <tr>
        <td>Voucher No. :</td>
        <td>{{$job_disp_data->vc_no}}</td>
        <td>VC Amt. :</td>
        <td>{{$job_disp_data->total_amt}}</td>
        <td>VC Status :</td>
        <td>{{$job_disp_data->vc_status}}</td>
      </tr>
      <tr>
        <td>Job Remark :</td>
        <td colspan="3">{{$job_disp_data->job_remark}}</td>
        <td>Print By :</td>
        <td>-{{Auth::user()->name}} {{date('d/m/Y h:i:s')}}</td>
      </tr>
    </table>
  </body>
</html>