<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeOfCharge extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'type', 'threshold', 'free_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
