<?php

namespace App\Filters;

use Auth;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function transform($item)
    { 
        if(isset($item['submenu'])){
            if(is_array($item['submenu'])){
                $sectionViewCheck = 0;
                foreach($item['submenu'] as $index => $page){
                    $item['submenu'][$index]['url'] = \LaravelLocalization::getCurrentLocale().'/'.$page['url'];
                    $permission = Auth::user()->permission($page['view'])->first();
                    if(!empty($permission)&&$permission->v==1){
                        if($page['view']!='xx'){
                           $sectionViewCheck = 1;
                        }
                    }else{
                        unset($item['submenu'][$index]);
                    }

                    if($page['view']=='xx'){
                        unset($item['submenu'][$index]);
                    }
                }

                if($sectionViewCheck==1){
                    $item['restricted'] = false; 
                }else{
                    $item['restricted'] = true; 
                }
            }
        }else{
            if(isset($item['view'])){
                if(!is_array($item['view'])){
                    $item['url'] = \LaravelLocalization::getCurrentLocale().'/'.$item['url'];
                    $permission = Auth::user()->permission($item['view'])->first();
                    if(!empty($permission)&&$permission->v==1){
                        if($item['view']!='xx'){
                          $item['restricted'] = false; 
                        }else{
                          $item['restricted'] = true; 
                        }
                    }else{
                        $item = '';
                    }  
                }
            }
        }

        return $item;
    }
}
