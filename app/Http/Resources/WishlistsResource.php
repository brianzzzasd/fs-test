<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $wishlists = array();

        foreach ($this->resource as $wishlist) {
            $wishlists[] = array(
                'id' => $wishlist->id,
                'name' => $wishlist->name,
                'shareable_link' => $wishlist->shareable_link,
                'organizer_name' => $wishlist->organizer->name,
                'wishlist_items' => new WishlistItemsResource($wishlist->wishlistItems),
            );
        }

        return $wishlists;
    }
}
