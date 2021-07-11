<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','phone','type_indetification_id','number_identification',
        'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Role(){
        return $this->belongsTo(Role::class);
    }

    public function Type_indetification(){
        return $this->belongsTo(Type_indetification::class);
    }

    public function scopeSearch($query,$filtro){
        if ($filtro) {
            return $query->where('name','like',"%$filtro%");
        }
    }

    public function scopeSearchStatus($query,$filtroS){
        if (!empty($filtroS) && $filtroS!="todos") {
            return $query->where('is_active','=',"$filtroS");
        }  
    }
}
