<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable=['id','roleName','permission','isAdmin'];

    protected $casts=[
        'id'=>'array',
        'roleName'=>'array',

    ];
//    public function role(){
//        return $this->belongsTo();
//    }
}
