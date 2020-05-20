<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Job_disp extends Model
{
	use LogsActivity;
    
     protected $table = 'job_disps';

     protected static $logAttributes = ['job_date', 'job_time', 'vh_type','booking_date','group_name','service_type','other_desc','guest_name','flight_detail','room_no','company','job_status','job_remark','vc_status','vc_total_hour','vh_no','driver_name','driver_comm_rate','vh_mile_out','vh_mile_in','vh_out_time','vh_in_time','trip_amount'];
}
