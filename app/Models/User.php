<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Поля, которые можно массово заполнять.
     * Добавь сюда 'is_admin', если планируешь назначать админов через код.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * Поля, которые должны быть скрыты для массивов (JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Связь с корзиной.
     * Теперь ты сможешь вызывать auth()->user()->cartItems
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Проверка на админа.
     * Удобно использовать как $user->is_admin
     */
    public function getIsAdminAttribute(): bool
    {
        return (bool) ($this->attributes['is_admin'] ?? false);
    }

    /**
     * Приведение типов.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
}
