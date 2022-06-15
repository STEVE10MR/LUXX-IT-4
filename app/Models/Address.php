<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "address";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable=[
        'user_id',
        'reference',
        'latitude',
        'longitude',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
