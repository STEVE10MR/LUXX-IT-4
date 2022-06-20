<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetails extends Model
{
    protected $table = "ordersdetails";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable=[
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];
    public function getRouteKeyName()
    {
        return 'id';
    }
}
