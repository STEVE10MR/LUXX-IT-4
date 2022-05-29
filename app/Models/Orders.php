<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable=[
        'latitude',
        'longitude',
        'status',
        'amount',
        'pay_type',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
