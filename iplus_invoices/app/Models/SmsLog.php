<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'warranty_id',
        'to',
        'text',
        'status',
        'response',
        'sent_at',
        'sent_by',
    ];
}
