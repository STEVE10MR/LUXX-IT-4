<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetails extends Model
{
    protected $table = "ordersdetails";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable=[
        'quantity',
        'price',
    ];
    public function getRouteKeyName()
    {
        return 'id';
    }
}
