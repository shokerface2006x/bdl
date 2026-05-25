<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'full_name', 'email', 'phone', 'address', 'total_price', 'status', 'tracking_number'];

    /**
     * Создаем виртуальное свойство status_text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'new'        => 'новый',
            'processing' => 'в обработке',
            'sent'       => 'отправлен',
            'completed'  => 'выполнен',
            'cancelled'  => 'отменен',
            default      => $this->status,
        };
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
