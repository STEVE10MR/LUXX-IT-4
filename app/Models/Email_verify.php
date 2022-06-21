<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email_verify extends Model
{
    protected $table = "email_verify";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable=[
        'email',
        'token',
    ];

}
