<?php

namespace Modules\Reserve\Http\Controllers\front;

use Modules\Product\Models\Product;

class ReserveController
{
    public function store(Product $product)
    {
        try {
            if (auth()->user()->reserves()->where('product_id', $product->id)->exists()) {
                throw new \Exception('شما این دوره را رزرو کرده اید');
            }
            auth()->user()->reserves()->create([
                'product_id' => $product->id,
                'know' => '',
            ]);
            return response()->json([
                'message' => "این دوره برای شما رزرو شد",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }

    }
}
