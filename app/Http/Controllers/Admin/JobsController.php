<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Http\Requests\JobRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    protected $pagination;

    public function __construct(){
        $this->pagination = config('adminlte.pagination');
    }

    public function save(JobRequest $request){
        $job = new Job();
        $job->name = $request->name;
        if($job->save()){
            return back()->with('success', 'Group saved successfully.');
        }else{
            return back();
        }

    }
    
    public function update(JobRequest $request){
        $job = Job::find($request->rowid);
        $job->name = $request->name;
        if($job->update()){
            return back()->with('success', 'Group updated successfully.');
        }else{
            return back();
        }

    }
    
    public function delete(Request $request){

        $validated = $request->validate([
            'rowid' => 'required',
        ]);

        $job = Job::find($request->rowid);

        if($job->delete()){
            return back()->with('success', 'Group deleted successfully.');
        }else{
            return back();
        }

    }
    
}
