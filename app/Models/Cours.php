<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;
    protected $table = 'cours';

    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    
    public function plannings(){
        return $this->hasMany(Planning::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'cours_users','cours_id', 'user_id');
    }
}
