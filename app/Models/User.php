<?php

namespace App\Models;

use Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = "users";
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function adminlte_image()
    {
        return asset('/avatar.png');
    }

    public function adminlte_desc()
    {
        $user = Auth::user();
        return $user->name.'<br>'.$user->getJob->name;
    }

    public function adminlte_profile_url(){
        return 'profile';
    }

    public function getJob()
    {
        return $this->belongsTo(Job::class, 'job', 'id');
    }

    public function permission($page){
        return $this->hasOne(Previliges::Class, 'job', 'job')->where('page', $page);
    }

}
