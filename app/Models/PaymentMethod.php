<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'type',
        'bank_name',
        'account_name',
        'account_number',
        'phone_number',
        'qr_image',
        'description',
        'is_active',
    ];
}