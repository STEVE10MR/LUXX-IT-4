<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passwordresets extends Model
{
    protected $table = "password_resets";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable=[
        'email',
        'token',
    ];

}
