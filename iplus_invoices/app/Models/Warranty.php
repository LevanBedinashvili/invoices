<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;
    protected $table = "warranties";
    protected $primaryKey = 'id';
    protected $guarded = [];

    function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    function template()
    {
        return $this->belongsTo('App\Models\Template');
    }

    function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
