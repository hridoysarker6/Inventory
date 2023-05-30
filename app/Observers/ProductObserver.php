<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "creating" event.
     */
    public function creating(Product $product): void
    {
        $random = Str::random(8);
        $uniqueCode = 'HR-'.$random;
        $product->code = $uniqueCode;
    }
}
