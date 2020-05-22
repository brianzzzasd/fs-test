<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $wishlistItems = array();

        foreach ($this->resource as $item) {
            $wishlistItems[] = array(
                'id'          => $item->id,
                'wishlist_id' => $item->wishlist_id,
                'name'        => $item->name,
                'price'       => $item->price,
                'description' => $item->description,
                'image_url'   => $item->image_url,
                'buyer_id'    => $item->buyer_id,
            );
        }
        
        return $wishlistItems;
    }
}
