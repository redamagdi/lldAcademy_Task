<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserProducts;

class OrdersController extends Controller
{
        protected $pagination;

        public function __construct(){
                $this->pagination = config('adminlte.pagination');
        }

        public function index(Request $request){
                $catids     = \Auth::user()->getJob->getCategoriesIDS();
                $pruductIDS = Product::select('id')->whereIn('category_id',json_decode($catids,true))->pluck('id');
                $rows       = UserProducts::whereIn('product_id',$pruductIDS)->with(['getProduct','getUser'])->paginate($this->pagination);
                return view("Admin.orders", compact("rows"));
        }

}
