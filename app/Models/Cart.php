<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "cart";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable=[
        'product_id',
        'user_id',
        'producto',
        'quantity',
        'price',
        'create',

    ];
    public function getRouteKeyName()
    {
        return 'id';
    }
}
