<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'description',
        'price_unit',
        'category',
        'supplier',
        'quantity_stock',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
