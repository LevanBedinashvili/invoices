<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "invoices";
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->uuid = (string) Str::uuid();
        });
    }

    protected $casts = [
        'is_signed' => 'boolean',
        'signed_at' => 'datetime',
    ];

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
