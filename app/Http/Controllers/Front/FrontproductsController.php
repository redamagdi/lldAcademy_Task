<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserProducts;

use App\Http\Requests\UserProductRequest;

class FrontproductsController extends Controller
{
        protected $pagination;

        public function __construct(){
                $this->pagination = config('adminlte.pagination');
        }

        public function index($category_id=""){
                $categories = Category::all(); 
                $rows       = Product::query();
                if($category_id!=""){
                   $rows->where('category_id',$category_id);   
                }
                $rows = $rows->paginate($this->pagination);
                
                return view("Front.products", compact("category_id","rows","categories"));
        }

        public function save(UserProductRequest $request){

                $row = new UserProducts();
                $row->user_id    = \Auth::user()->id;
                $row->product_id = $request->rowid;
                $row->price      = $request->price;
                $row->amount     = $request->amount;
                $row->total      = $request->price*$request->amount;
                if($row->save()){
                        return back()->with('success', __('auth.addMessageSuccess'));
                }else{
                        return back();
                }
        
        }
}
