<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function driver_assigned()
    {
        return $this->belongsTo(User::class, 'driver_assigned');
    }
    public function assigned_by()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
