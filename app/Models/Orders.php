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
        'client_id',
        'delivery_id',
        'address_id',
        'status',
        'recept',
        'amount',
        'pay_type',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
