<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getProducts()
    {
        /*        $data = [];
                foreach ($this->items as $item) {
                    $data[] = $item->product_id;
                }

                return $data;*/

        return $this->items->map(function ($item) {
            return $item->product_id;
        });

    }

    public function getPrice()
    {
        /*        $price = 0;
                foreach ($this->items as $item) {
                    $price += $item->price;
                }

                return $price;*/

        return $this->items->reduce(function ($sum, $item) {
            return $sum + $item->price;
        }, 0);

    }

    protected $guarded = [];
}
