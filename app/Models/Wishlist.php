<?php

namespace App\Models;

use App\Models\WishlistItems;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $guarded = [];

   	public function wishlistItems()
   	{
   		return $this->hasMany(WishlistItems::class);
   	}
}
