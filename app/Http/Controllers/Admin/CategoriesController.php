<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\AdminCategories;
use App\Http\Requests\CategoryRequest;
class CategoriesController extends Controller
{
        protected $pagination;

        public function __construct(){
                $this->pagination = config('adminlte.pagination');
        }

        public function index(Request $request){
                $catids = AdminCategories::select('category_id')->where('group_id',\Auth::user()->job)->pluck('category_id');
                $rows   = Category::whereIn('id',$catids)->paginate($this->pagination);
                return view("Admin.categories", compact("rows"));
        }

        public function save(CategoryRequest $request){
                $row = new Category();
                $row->name = $request->name;
                if($row->save()){
                        $newCatPre = new AdminCategories();
                        $newCatPre->group_id    = \Auth::user()->job;
                        $newCatPre->category_id = $row->id;
                        $newCatPre->save();
                        
                        return back()->with('success', __('auth.addMessageSuccess'));
                }else{
                        return back();
                }
        
        }
            
        public function update(CategoryRequest $request){
                $row = Category::find($request->rowid);
                $row->name = $request->name;
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
                $row = Category::find($request->rowid);
                if($row->delete()){
                        $catPre = AdminCategories::where(['category_id'=>$request->rowid,'group_id'=>\Auth::user()->job])->get();
                        foreach($catPre as $c){
                                $c->delete();
                        }
                        return back()->with('success',__('auth.deleteMessageSuccess') );
                }else{
                        return back();
                }

        }

}
