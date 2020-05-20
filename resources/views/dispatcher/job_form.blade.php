<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style type="text/css">
      body{
        font-family: Tahoma,Lucida Grande, Lucida Sans, Arial, sans-serif;
        font-size: 16px;
      }
      .title{
        font-size: 20px;
        font-weight: 700;
      }
      .title-company{
        font-size: 16px;
      }
      .border-bottom{
        border-bottom: 1px solid #000;
      }
      .box{
        padding: 10px;
        border: 1px solid #000;
      }
      .border {
        border: 1px solid #000;
      }
      .padding-box{
        padding: 5px 10px;
      }
      .padding-x{
        padding: 0px 10px;
      }
      .padding-y{
        padding: 10px 0px;
      }
      .margin-top{
        margin-top: 25px;
      }
      @page { margin: 15px; }
      body { margin: 0px; }
    </style>
  </head>
  <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80%">
          <table style="text-align: center;" width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td><img src="{{public_path('dist/img/howa.png')}}" width="80px" /></td>
            </tr>
            <tr>
              <td>
                <div class="title-company">บริษัท เบลล์ ทรานสปอร์ต จำกัด</div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="title-company">BELL TRANSPORT CO.,LTD.</div> 
              </td>
            </tr>
            <tr>
              <td>
                <div class="title">JOB ORDER</div>
              </td>
            </tr>
          </table>
        </td>
        <td width="20%" rowspan="2" valign="top">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center">Car No.</td>
            </tr>
            <tr>
              <td align="center" class="border padding-box">{{$job_disp_data->vh_no}}</td>
            </tr>
          </table>
          <table width="100%" class="border margin-top" border="0" cellpadding="3" cellspacing="0">
            @foreach ($service_type as $val=>$type)
            <tr>
              <td class="border-bottom" width="20%"><input type="checkbox" {{($val==$job_disp_data->service_type)?'checked':''}} /></td>
              <td class="border-bottom" width="80%">{{$type}}</td>
            </tr>
            @endforeach
          </table>
        </td>
      </tr>
      <tr>
        <td valign="top">
          <table width="98%" class="padding-y" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="15%" valign="bottom" class="padding-y">Date:</td>
              <td width="35%" class="border-bottom padding-y">{{date('d/m/Y',strtotime($job_disp_data->job_date))}}</td>
              <td width="15%" valign="bottom" class="padding-y">Time:</td>
              <td width="35%" class="border-bottom padding-y">{{date('H:i',strtotime($job_disp_data->job_time))}}</td>
            </tr>
            <tr>
              <td valign="bottom" class="padding-y">Driver:</td>
              <td colspan="3" class="border-bottom padding-y">{{$job_disp_data->driver_name}}</td>
            </tr>
            <tr>
              <td valign="bottom" class="padding-y">Time Out:</td>
              <td class="border-bottom padding-y">{{$job_disp_data->driver_name}}</td>
              <td valign="bottom" class="padding-y">Time In:</td>
              <td class="border-bottom padding-y">{{$job_disp_data->driver_name}}</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table width="100%" class="margin-top" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80%" class="padding-x padding-y"><b>GUEST NAME</b></td>
        <td width="20%" class="border" align="center" >CODE</td>
      </tr>
      <tr>
        <td class="padding-x"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="20%" class="padding-y">Name :</td><td width="80%" class="border-bottom" >{{$job_disp_data->guest_name}}</td></tr></table></td>
        <td class="border" align="center">{{$job_disp_data->room_no}}</td>
      </tr>
      <tr>
        <td class="padding-x"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="20%" class="padding-y">Flight Detail :</td><td width="80%" class="border-bottom">{{$job_disp_data->flight_detail}}</td></tr></table></td>
        <td class="border"></td>
      </tr>
      <tr>
        <td class="padding-x"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="20%" class="padding-y">Arr. Time :</td><td width="80%" class="border-bottom">{{date('H:i',strtotime($job_disp_data->booking_date))}}</td></tr></table></td>
        <td class="border"></td>
      </tr>
    </table>
    <table width="100%" class="margin-top" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="6" class="padding-x padding-y"><b>AIRPORT TRANSFER</b></td>
      </tr>
      <tr>
        <td width="13%" valign="bottom" class="padding-y">Flight:</td>
        <td width="17%" class="border-bottom padding-y"></td>
        <td width="13%" valign="bottom" class="padding-y">Time:</td>
        <td width="17%" class="border-bottom padding-y"></td>
        <td width="13%" valign="bottom" class="padding-y">Ter:</td>
        <td width="" class="border-bottom padding-y"></td>
      </tr>
      <tr>
        <td valign="bottom" class="padding-y">A/P Rep:</td>
        <td colspan="3" class="border-bottom padding-y"></td>
        <td valign="bottom" class="padding-y">Time:</td>
        <td class="border-bottom padding-y"></td>
      </tr>
    </table>
    <table width="100%" class="margin-top" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="6" class="padding-x padding-y"><b>DROP OFF / PICK UP</b></td>
      </tr>
      <tr>
        <td width="25%" valign="bottom" class="padding-y">Telephone No. :</td>
        <td width="40%" class="border-bottom padding-y"></td>
        <td width="15%" valign="bottom" class="padding-y">Time:</td>
        <td width="20%" class="border-bottom padding-y"></td>
      </tr>
      <tr>
        <td valign="bottom" class="padding-y">Contact Person :</td>
        <td colspan="2" class="border-bottom padding-y"></td>
        <td rowspan ="3">
          <table width="100%" border="1" cellpadding="3" cellspacing="0" class="margin-top">
            <tr>
              <td>STANDARDS</td>
            </tr>
            <tr>
              <td>Mineral Water</td>
            </tr>
            <tr>
              <td>Cold Towels</td>
            </tr>
            <tr>
              <td>Drive Time</td>
            </tr>
            <tr>
              <td>Temperature</td>
            </tr>
            <tr>
              <td>Music</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td valign="bottom" class="padding-y">Other Desc:</td>
        <td colspan="2"><p class="border-bottom">{{$job_disp_data->other_desc}}</p></td>
      </tr>
      <tr>
        <td valign="bottom" class="padding-y">Remark :</td>
        <td colspan="2"><p class="border-bottom">{{$job_disp_data->job_remark}}</p></td>
      </tr>
    </table>
  </body>
</html>