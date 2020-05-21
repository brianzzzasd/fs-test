<?php

namespace App\Http\Controllers;

use App\Http\Resources\WishlistsResource;
use App\Models\Wishlist;
use App\Models\WishlistItems;
use DB;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishlists = Wishlist::all()->take(10);

        return new WishlistsResource($wishlists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wishlistData = json_decode($request->wishlist);

        try {
            DB::beginTransaction();

            $wishlist = Wishlist::create([
                'name' => $wishlistData->wishlist_name,
                'organizer_id' => auth('api')->id(),
                'shareable_link' => 'testlink'
            ]); 

            $wishListItems = json_decode($wishlistData->wishlist_items, true);

            $this->createWishlistItems($wishListItems, $wishlist->id, $request->all());

            DB::commit();
            return response()->json([
                'message' => 'Wishlist Created Successfully',
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Wishlist $wishlist)
    {
        $wishlist->delete();
    }

    public function createWishlistItems($items, $id, $files)
    {
        collect($items)->each(function ($item, $index) use($id, $files) {
            $img_url = '';
            $file_index = 'image-' . $index;

            if ($file = $files[$file_index]) {
                $img_url = $file->store('uploads');
            }

            WishlistItems::create(array_filter([
                'name' => $item['name'],
                'wishlist_id' => $id,
                'description' => $item['description'],
                'image_url' => $img_url,
                'price' => $item['price']
            ]));
        });
    }
}
