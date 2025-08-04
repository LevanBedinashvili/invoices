<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Warranty extends Model
{
    use HasFactory;
    protected $table = "warranties";
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name',
        'last_name',
        'personal_number',
        'device_imei_code',
        'device_name',
        'branch_id',
        'template_id',
        'phone_number',
        'user_id',
        'uuid',
        'signed_at',
        'signed_ip',
        'signed_phone',
        'signed_name',
        'signed_surname',
        'is_signed',
    ];

    public static function generateSignToken()
    {
        return bin2hex(random_bytes(24));
    }

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
