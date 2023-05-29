<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PurchaseController extends Controller
{
    public function store(PurchaseStoreRequest $request)
    {

        try {
            DB::beginTransaction();
        
            $purchaseData = $request->only(['date', 'invoice_no', 'supplier_id', 'total_amount', 'note']);
            $purchase = Purchase::create($purchaseData);
        
            $purchaseItems = collect($request->purchase_items);

            $productIds = $purchaseItems->pluck('product_id')->toArray(); 
             $products = Product::whereIn('id', $productIds)->get() ;
        
           
             $purchaseItems->each(function ($item) use ($purchase, $products) {
                $productId = $item['product_id'];
    
                if ( $product = $products->find($productId)) {
                     
                    $quantity = $item['quantity'];
        
                    PurchaseDetail::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ]);
        
                    $product->increment('quantity', $quantity);
                    $product->update(['price' => $item['price']]);
                }else{
                    throw new NotFoundHttpException('product not found');
                }
            });
        
            DB::commit();
        
            
        } catch (\Exception $e) {
            DB::rollBack();
            
        }
        
return $this->json('Purchase successfully', new PurchaseResource($purchase));
    }
}
