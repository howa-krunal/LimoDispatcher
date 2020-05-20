<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobFileAtt;
use File;

class AjaxUploadController extends Controller
{
    //
    public function index($id) {
    	// Get listing 
        return datatables()->of(JobFileAtt::where('job_disps_id', $id)->get())->make(true);
    }
    public function store(Request $request) {
		request()->validate([
		      'filename' => 'required|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
		 ]);
		 
		 if ($request->file('filename')) {
		     
		    // for save original image
		    /*$ImageUpload = Image::make($files);
		    $originalPath = 'public/jobfileatt/';
		    $ImageUpload->save($originalPath.time().$files->getClientOriginalName());*/

		    $jobfile = $request->file('filename');
			$old_name = $jobfile->getClientOriginalName();
			$file_name = pathinfo($old_name, PATHINFO_FILENAME);
			$extension = pathinfo($old_name, PATHINFO_EXTENSION);
			$new_name = $file_name.'_'.time().'.'.$extension;

			$jobfile->move(public_path('jobfileatt'), $new_name);
		 
			$fileAtt = new JobFileAtt();
			$fileAtt->job_disps_id = $request->job_disps_id;
			$fileAtt->filename = $new_name;
			$fileAtt->save();
		}
		 
		$image = JobFileAtt::latest()->first(['filename']);
		return Response()->json($image);
    }
    public function remove(Request $request){
        if(isset($request->job_file_id) && !empty($request->job_file_id)){
            $jobFile = new JobFileAtt(); 
            $jobData = $jobFile->where(array('id' => $request->job_file_id))->first();
            $jobFile->where(array('id' => $request->job_file_id))->delete();

			if(isset($jobData->filename) && !empty($jobData->filename) && File::exists(public_path('jobfileatt/'.$jobData->filename))){
				File::delete(public_path('jobfileatt/'.$jobData->filename));
			}else{
				dd('File does not exists.');
			}
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }
}
