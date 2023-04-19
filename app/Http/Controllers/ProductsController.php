<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
        protected $pagination;

        public function __construct(){
                $this->pagination = config('adminlte.pagination');
        }

        public function index(Request $request){
                $catids     = \Auth::user()->getJob->getCategoriesIDS();
                $categories = Category::whereIn('id',json_decode($catids,true))->get(); 
                $rows       = Product::whereIn('category_id',json_decode($catids,true))->paginate($this->pagination);
                return view("Admin.products", compact("rows","categories"));
        }

        public function save(Request $request){

                $validated = $request->validate([
                    'name' => 'required',
                    'price' => 'required',
                    'description' => 'required',
                    'category_id' => 'required',
                ]);
                
                $row = new Product();
                $row->name = $request->name;
                $row->price = $request->price;
                $row->description = $request->description;
                $row->category_id = $request->category_id;
                if($row->save()){
                        return back()->with('success', __('auth.addMessageSuccess'));
                }else{
                        return back();
                }
        
        }
            
        public function update(Request $request){

            $validated = $request->validate([
                'rowid' => 'required',
                'name' => 'required',
                'price' => 'required',
                'description' => 'required',
                'category_id' => 'required',
            ]);

                $row = Product::find($request->rowid);
                $row->name = $request->name;
                $row->price = $request->price;
                $row->description = $request->description;
                $row->category_id = $request->category_id;

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
                $row = Product::find($request->rowid);
                if($row->delete()){
                        return back()->with('success',__('auth.deleteMessageSuccess') );
                }else{
                        return back();
                }

        }

}
