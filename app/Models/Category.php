<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable=[
        'category',
        'description',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
