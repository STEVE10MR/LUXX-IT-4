<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "address";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable=[
        'refence',
        'latitude',
        'longitude',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
