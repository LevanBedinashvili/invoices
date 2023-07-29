<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_type extends Model
{
    use HasFactory;
    protected $table = "payment_types";
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
