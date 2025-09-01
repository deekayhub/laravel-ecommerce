<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;



class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';


    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'phone',
        'notes',
    ];

    /**
     * Relationship: Each order belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    /**
     * (Optional) Relationship: Orders usually have multiple items
     * If you create an OrderItem model/table
     */
    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }
}
