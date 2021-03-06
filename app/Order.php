<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "orders";
    protected $guarded = ["id"];
  	protected $softDelete = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function itemOrders()
    {
        return $this->hasMany('App\ItemOrder');
    }

    public function products()
  	{
    return $this->belongsToMany('App\Product', 'item_orders');
  	}

    public function getcartTotalAttribute()
    {
    $total = 0;
    foreach ($this->itemOrders as $item)
    {
    $total += ($item->price * $item->qty);
    }
    return $total;
    }

    public function mop()
    {
        return $this->morphTo();
    }
    public static function findByUserID($uid)
    {
        return self::where('user_id', $uid)->get();
    }

 
    
}
