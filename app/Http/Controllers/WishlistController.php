<?php

namespace App\Http\Controllers;

use App\Http\Resources\WishlistItemsResource;
use App\Http\Resources\WishlistsResource;
use App\Models\Wishlist;
use App\Models\WishlistItems;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
     * Get wishlist
     *
     * @return object
     */
    public function view()
    {
        $wishlist = Wishlist::where('id', request()->id)->get();

        return new WishlistsResource($wishlist);
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

    /**
     * Create Wishlist Items
     * 
     * @param  array $items 
     * @param  int $id    
     * @param  \File $files 
     * 
     * @return void
     */
    public function createWishlistItems($items, $id, $files)
    {
        collect($items)->each(function ($item, $index) use($id, $files) {
            $img_url = '';
            $file_index = 'image-' . $index;

            if ($file = $files[$file_index]) {
                $fileName = Str::random(12) . '.' . $file->getClientOriginalExtension();

                $img_url = request()->getSchemeAndHttpHost() . '/storage/uploads/' . $fileName;
                $file->storeAs('public/uploads', $fileName);
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

    /**
     * Buy Wishlist Item
     * 
     * @return WishlistResource
     */
    public function buyItem()
    {
        $item = WishlistItems::find(request()->id);

        $item->update([
            'buyer_id' => auth('api')->id(),
        ]);

        return new WishlistsResource($item->wishlist()->get());
    }

    /**
     * Buy Wishlist Item
     * 
     * @return WishlistItemsResource
     */ 
    public function getItem()
    {
        $item = WishlistItems::whereId(request()->id)->get();   
        $resItem = new WishlistItemsResource($item);
        dump($resItem);
        return new WishlistItemsResource($item);
    }

    public function updateItem()
    {
        $item = WishlistItems::find(request()->id);   

        $img_url = '';

        if ($file = request()->image) {
            $fileName = Str::random(12) . '.' . $file->getClientOriginalExtension();

            $img_url = request()->getSchemeAndHttpHost() . '/storage/uploads/' . $fileName;
            $file->storeAs('public/uploads', $fileName);
        }

        $item->update(array_filter([
            'name' => $item['name'],
            'wishlist_id' => $id,
            'description' => $item['description'],
            'image_url' => $img_url,
            'price' => $item['price']
        ]));
    }
}
