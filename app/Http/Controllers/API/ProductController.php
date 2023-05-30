<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest()
            ->when($request->has('search_key'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search_key.'%')
                    ->orWhere('code', 'like', '%'.$request->search_key.'%');
            })->paginate($request->get('per_page', 10));

        return ProductResource::collection($products);
    }

    public function getActiveProduct(Request $request)
    {
        $products = Product::isActive()->latest()
            ->when($request->has('search_key'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search_key.'%')
                    ->orWhere('code', 'like', '%'.$request->search_key.'%');
            })->paginate($request->get('per_page', 10));

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request)
    {
        $filePath = null;
        if ($request->hasFile('image')) {
            $filePath = $this->uploadProductImage($request->file('image'));
        }

        $product = Product::create([

            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $filePath,
        ]);

        return $this->json('Product stored successfully', new ProductResource($product));
    }

    private function uploadProductImage($file)
    {
        $extension = $file->extension();
        $fileName = now()->format('Y_m_d_His.').$extension;
        $path = 'products/';
        $filePath = $path.$fileName;
        Storage::put($filePath, file_get_contents($file));

        return $filePath;
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);

        return $this->json('Product details', new ProductResource($product));
    }

    public function update($productId, ProductStoreRequest $request)
    {
        $product = Product::findOrFail($productId);

        $product->update([

            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'description' => $request->description,
            'status' => $request->status,

        ]);

        return $this->json('Product update successfully', new ProductResource($product->refresh()));
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId)->delete();

        return $this->json('Product delete successfully');
    }
}
