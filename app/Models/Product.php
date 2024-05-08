<?php

namespace App\Models;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function freeOfCharges()
    {
        return $this->hasMany(FreeOfCharge::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'product_prices', 'product_id', 'user_id');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
