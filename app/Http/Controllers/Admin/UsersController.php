<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
        protected $pagination;

        public function __construct(){
                $this->pagination = config('adminlte.pagination');
        }

        public function index(Request $request){
                $rows = User::where('type','U')->paginate($this->pagination);
                return view("Admin.users", compact("rows"));
        }

        public function save(UserRequest $request){
                $row = new User();
                $row->name = $request->name;
                $row->password = md5($request->password);
                $row->status = $request->status;
                $row->email = $request->email;
                $row->phone = $request->phone;
                $row->type = 'U';
                if($row->save()){
                        return back()->with('success', __('auth.addMessageSuccess'));
                }else{
                        return back();
                }
        
        }
            
        public function update(UserRequest $request){

                $row = User::find($request->rowid);
                $row->name = $request->name;
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
