<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'invoice_no',
        'supplier_id',
        'total_amount',
        'note',
    ];

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
