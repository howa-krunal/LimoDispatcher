<?php

namespace App\Http\Controllers;

use App\JobAutoQueue;
use Illuminate\Http\Request;

class JobAutoQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get listing 
        return datatables()->of(JobAutoQueue::join('branches as driver_branches', 'driver_branches.id', '=', 'job_auto_queue.branch_id')->join('branches as auto_branches', 'auto_branches.id', '=', 'job_auto_queue.branch_id')->select('job_auto_queue.*','driver_branches.short_name as driver_short_name','auto_branches.short_name as auto_short_name'))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->session()->has('office_ids')){
            $selected_office = session('office_ids');
            if (sizeof($selected_office) == 1) {
                $default_office_id = $selected_office[0];
            }else {
                $default_office_id = $selected_office[0];
            }            
        }
        $new_auto_queue = new JobAutoQueue();

        $new_auto_queue->branch_id = $default_office_id;
        $new_auto_queue->driver_office_id = $request->queue_driver_office;
        $new_auto_queue->driver_id = $request->queue_driver_code;
        $new_auto_queue->driver_name = $request->queue_driver_name;
        $new_auto_queue->last_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->queue_last_date )));
        $new_auto_queue->vh_office_id = $request->queue_car_office;
        $new_auto_queue->vh_id = $request->queue_car_no;
        $new_auto_queue->vh_no = $request->queue_plate_no;

        $new_auto_queue->save();
        //activity('default')->performedOn($new_auto_queue)->log('Created-Auto-Queue');
        return array('success' =>1 );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobAutoQueue  $jobAutoQueue
     * @return \Illuminate\Http\Response
     */
    public function show(JobAutoQueue $jobAutoQueue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobAutoQueue  $jobAutoQueue
     * @return \Illuminate\Http\Response
     */
    public function edit(JobAutoQueue $jobAutoQueue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobAutoQueue  $jobAutoQueue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobAutoQueue $jobAutoQueue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobAutoQueue  $jobAutoQueue
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobAutoQueue $jobAutoQueue)
    {
        //Delete auto queue
        
    }
    public function removeJobAutoQueue(Request $request){
        if(isset($request->auto_queue_id) && !empty($request->auto_queue_id)){
            $jobAutoQueue = new JobAutoQueue(); 
            $jobAutoQueue->where(array('id' => $request->auto_queue_id))->delete();

            //activity('default')->performedOn($jobAutoQueue)->log('Remove-Auto-Queue');

            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }
}
