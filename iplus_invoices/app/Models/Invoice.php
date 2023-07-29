<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "invoices";
    protected $primaryKey = 'id';
    protected $guarded = [];

    function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function payment_type()
    {
        return $this->belongsTo(Payment_type::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
