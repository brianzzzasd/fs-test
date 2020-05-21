<?php

namespace App\Http\Controllers;

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
        return Wishlist::paginate($request->query ?? 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
