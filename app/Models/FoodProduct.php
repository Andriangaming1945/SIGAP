<?php
// app/Models/FoodProduct.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodProduct extends Model
{
    protected $fillable = [
        'barcode',
        'name',
        'ingredients',
        'dangerous_ingredients'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'dangerous_ingredients' => 'array'
    ];
}