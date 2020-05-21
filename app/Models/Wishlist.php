<?php

namespace App\Models;

use App\Models\WishlistItems;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
	use SoftDeletes;
    protected $guarded = [];

   	public function wishlistItems()
   	{
   		return $this->hasMany(WishlistItems::class);
   	}

   	public function organizer()
   	{
   		return $this->belongsTo(User::class, 'organizer_id');
   	}
}
