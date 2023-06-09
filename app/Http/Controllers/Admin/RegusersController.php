<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Job;
use App\Http\Requests\AdminRequest;

class RegusersController extends Controller
{
        protected $pagination;

        public function __construct(){
                $this->pagination = config('adminlte.pagination');
        }

        public function index(Request $request){
                $rows = User::where('type','A')->with(['getJob'])->paginate($this->pagination);
                $groups = Job::all();
                return view("Admin.settings.regusers", compact("rows","groups"));
        }

        public function save(AdminRequest $request){
                $row = new User();
                $row->name = $request->name;
                $row->password = md5($request->password);
                $row->job = $request->job;
                $row->status = $request->status;
                $row->email = $request->email;
                $row->phone = $request->phone;
                $row->type = 'A';
                if($row->save()){
                        return back()->with('success', __('auth.addMessageSuccess'));
                }else{
                        return back();
                }
        
        }
            
        public function update(Request $request){
                $row = User::find($request->rowid);
                $row->name = $request->name;
                $row->job = $request->job;
                $row->status = $request->status;
                $row->email = $request->email;
                $row->phone = $request->phone;
                if($row->update()){
                  return back()->with('success', __('auth.updateMessageSuccess'));
                }else{
                  return back();
                }

        }
        
        public function delete(Request $request){

                $validated = $request->validate([
                        'rowid' => 'required',
                ]);

                $row = User::find($request->rowid);

                if($row->delete()){
                        return back()->with('success',__('auth.deleteMessageSuccess') );
                }else{
                        return back();
                }

        }

        public function resetPass(Request $request){

                $validated = $request->validate([
                        'rowid' => 'required',
                        'password' => 'required',
                ]);

                $row = User::find($request->rowid);
                $row->password = md5($request->password);
                if($row->save()){
                        return back()->with('success', __('auth.updateMessageSuccess'));
                }else{
                        return back();
                }

        }

}
