<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'invoice_no' => $this->invoice_no,
            'supplier_id' => $this->supplier_id,
            'total_amount' => $this->total_amount,
            'note' => $this->note,
            'purchase_details' => PurchaseDetailResource::collection($this->purchaseDetails),
        ];
    }
}
