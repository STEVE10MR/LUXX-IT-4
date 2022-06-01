<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "products";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable=[
        'portada',
        'category_id',
        'name',
        'descripcion',
        'price',
        'status',
        'url'
    ];
    public function getRouteKeyName()
    {
        return 'url';
    }
}
