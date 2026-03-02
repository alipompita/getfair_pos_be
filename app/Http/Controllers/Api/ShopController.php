<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Shop;
use App\Models\User;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = User::find(auth('sanctum')->id())->shops()->get();

        return response()->json([
            'success' => true,
            'shops' => $shops,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Create the shop
            $shop_id = uniqid(); // Generate a unique ID for the shop

            $shop = Shop::create([
                // 'id' => $shop_id,
                'name' => $request->name,
                'description' => $request->description,
                'subscription_status' => 'pending',
                'subscription_expiry' => now()->addDays(3),
            ]);

            return response()->json([
                'success' => true,
                'shop' => $shop,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Shop creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shop = Shop::where('id', $id)->where('owned_by', auth('sanctum')->id())->with('users')->first();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => 'Shop not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'shop' => $shop,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
