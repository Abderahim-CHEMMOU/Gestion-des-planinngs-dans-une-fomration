<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;

   // protected $table = 'users';

    public $timestamps = false;

    protected $hidden = ['mdp'];

    protected $fillable = ['login', 'mdp', 'type'];

    public function getAuthPassword(){
        return $this->mdp;
    }

    public function isAdmin(){
        return $this->type == 'admin';
    }

    public function isStudent(){
        return $this->type == 'etudiant';
    }

    public function isTeacher(){
        return $this->type == 'enseignant';
    }

    public function formation(){
        return $this->belongsTo(Formation::class);
    }

    public function cours(){
        return $this->hasMany(Cours::class);
    }

    public function polyCours(){
        return $this->belongsToMany(Cours::class,'cours_users','user_id', 'cours_id');
    }
    
}
