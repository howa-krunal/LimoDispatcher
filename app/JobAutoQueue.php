<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class JobAutoQueue extends Model
{
	use LogsActivity;

    protected $table = 'job_auto_queue';

    protected static $logAttributes = ['driver_name', 'last_date', 'vh_no'];
    //protected static $recordEvents = ['deleted'];
}
