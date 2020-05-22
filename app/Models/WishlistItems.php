<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItems extends Model
{
    protected $guarded = [];

    public function wishlist()
    {
    	return $this->belongsTo(Wishlist::class, 'wishlist_id');
    }
}
