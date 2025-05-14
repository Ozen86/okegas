<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{   

    use HasFactory;

    protected $fillable = [
        'name',        
        'description', 
        'stock',       
        'price',
        'image',
        'category_id',
        'shop_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',  
        'stock' => 'integer'     
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
