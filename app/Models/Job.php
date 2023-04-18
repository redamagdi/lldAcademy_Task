<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = "jobs";
    protected $guarded = [];
    public $timestamps = false;

    public function getCategories()
    {
        return $this->hasMany(AdminCategories::class, 'group_id');
    }

    public function getCategoriesIDS()
    {
        $IDS = [];
        foreach($this->getCategories as $c){
            array_push($IDS,$c->category_id);
        }
        
        return json_encode($IDS);
    }
}
