<?php

namespace App\Models;

use App\Enums\ShopProductItemType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopProductItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => ShopProductItemType::class
    ];

    protected $appends = [
        'image'
    ];

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type->getImage($this->data)
        );
    }
}
