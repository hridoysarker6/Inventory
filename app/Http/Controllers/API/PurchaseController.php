<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(PurchaseStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $purchaseData = $request->only(['date', 'invoice_no', 'supplier_id', 'total_amount', 'note']);
            $purchase = Purchase::create($purchaseData);

            $purchaseItems = collect($request->purchase_items);

            $productIds = $purchaseItems->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $productIds)->get();

            $purchaseItems->map(function ($item) use ($purchase, $products) {
                $productId = $item['product_id'];

                $product = $products->find($productId);

                $quantity = $item['quantity'];

                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);

                $product->price = $item['price'];
                $product->quantity += $quantity;
                $product->save();
            });

            return $this->json('Purchase successfully', new PurchaseResource($purchase));
        });
    }
}
