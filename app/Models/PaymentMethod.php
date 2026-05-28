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

    public function displayTypeLabel(): string
    {
        return match ($this->type) {
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'vnpay' => 'VNPay',
            'cash' => 'Tiền mặt',
            default => $this->type ?? 'Không xác định',
        };
    }
}