<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = "invoice_items";
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }


    function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
