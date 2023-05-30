<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::query()
            ->when($request->has('search_key'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search_key').'%');
            })
            ->take($request->get('per_page', 10))->get(['id', 'name']);

        return $this->json('supplier list', $suppliers);
    }
}
