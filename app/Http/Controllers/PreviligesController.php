<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\AdminCategories;

use App\Models\Previliges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreviligesController extends Controller
{

    public function index(Request $request){
        $jobs           = Job::all();
        $categories     = Category::all();
        return view("settings.privileges", compact("jobs","categories"));
    }

    public function job($jobid){
        $job = Job::where("id", $jobid)->first();
        $pages = $this->buildMenu($jobid);
        $categories     = Category::all();
        return view("settings.privileges", compact("job", "pages","categories"));
    }

    public function getPrevilige($jobid, $page){
        $privileges = Previliges::select("v","a","e","d")->where(["job"=>$jobid, "page"=>$page])->first();
        return $privileges;
    }

    public function buildMenu($jobid){
        $i = 0;
        $pages = [];

        $pages[$i] = (object)["section"=>__('auth.generalSettingsPages'), "pages"=>[]];
        $sectionPages = [
            ["name" => __('auth.Dashboard'), "route" => "dashboard", "previliges" => $this->getPrevilige($jobid, "dashboard")],
            ["name" => __('auth.categories'), "route" => "categories", "previliges" => $this->getPrevilige($jobid, "categories")],
            ["name" => __('auth.products'), "route" => "products", "previliges" => $this->getPrevilige($jobid, "products")],
            ["name" => __('auth.users'), "route" => "users", "previliges" => $this->getPrevilige($jobid, "users")],
            ["name" => __('auth.orders'), "route" => "orders", "previliges" => $this->getPrevilige($jobid, "orders")],
        ];
        $pages[$i++]->pages = $sectionPages;
        
        $pages[$i] = (object)["section"=>__('auth.UsersManagement'), "pages"=>[]];
        $sectionPages = [
            ["name" => __('auth.Groupspreviliges'), "route" => "previlige", "previliges" => $this->getPrevilige($jobid, "previlige")],
            ["name" => __('auth.admins') , "route" => "regusers", "previliges" => $this->getPrevilige($jobid, "regusers")],
        ];
        $pages[$i++]->pages = $sectionPages;

        return $pages;
    }

    public function update(Request $request){

        $validated = $request->validate([
            'route' => 'required',
            'jobid' => 'required',
            'view' => 'required',
            'add' => 'required',
            'edit' => 'required',
            'delete' => 'required',
        ]);

        $previliges = Previliges::where(["job" => $request->jobid, "page" => $request->route])->first();
        if($previliges){
            $previliges->v = $request->view;
            $previliges->a = $request->add;
            $previliges->e = $request->edit;
            $previliges->d = $request->delete;
            if($previliges->update()){
                if($previliges->page=="categories"){
                    $jobD = Job::where('id',$request->jobid)->with(['getCategories'])->first();
                    $jobD->getCategories()->delete();
                    if($previliges->v==1){
                        foreach($request->categories as $c){
                            $newCatePre = new AdminCategories();
                            $newCatePre->group_id = $request->jobid;
                            $newCatePre->category_id = $c;
                            $newCatePre->save();
                        }
                    }
                }

                return back()->with('success', 'Privilege updated successfully.');
            }else{
                return back()->with('error', 'Privilege not updated.');
            }
        }else{
            $previliges = new Previliges();
            $previliges->job = $request->jobid;
            $previliges->page = $request->route;
            $previliges->v = $request->view;
            $previliges->a = $request->add;
            $previliges->e = $request->edit;
            $previliges->d = $request->delete;
            if($previliges->save()){
                if($previliges->page=="categories"){
                    $jobD = Job::where('id',$request->jobid)->with(['getCategories'])->first();
                    $jobD->getCategories()->delete();
                    if($previliges->v==1){
                        foreach($request->categories as $c){
                            $newCatePre = new AdminCategories();
                            $newCatePre->group_id = $request->jobid;
                            $newCatePre->category_id = $c;
                            $newCatePre->save();
                        }
                    }
                }

                return back()->with('success', 'Privilege saved successfully.');
            }else{
                return back()->with('error', 'Privilege not saved.');
            }
        }

    }
    
    public function delete(Request $request){

        $validated = $request->validate([
            'rowid' => 'required',
        ]);

        $job = Job::find($request->rowid);

        if($job->delete()){
            return back()->with('success', 'Job deleted successfully.');
        }else{
            return back();
        }

    }
    
}
