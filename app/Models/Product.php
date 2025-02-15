<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'productName',
        'productImage',
        'price',
        'quantity',
        'description',
        'brand_id',
        'category_id',
        'supplier_id'
    ];


}
