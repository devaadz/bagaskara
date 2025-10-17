<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesSummary extends Model
{
    use HasFactory;

    protected $table = 'sales_summary';

    protected $fillable = [
        'transaction_date',
        'transaction_id',
        'order_id',
        'product_id',
        'category_id',
        'quantity_sold',
        'unit_price',
        'subtotal',
        'discount_id',
        'discount_amount',
        'price_after_discount',
        'voucher_id',
        'voucher_percent',
        'voucher_applied',
        'total_revenue',
        'payment_method',
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔗 RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ⚙️ AUTOMATIC CALCULATIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // 1️⃣ Hitung subtotal
            $model->subtotal = $model->unit_price * $model->quantity_sold;

            // 2️⃣ Harga setelah diskon item
            $model->price_after_discount = $model->subtotal - $model->discount_amount;

            // 3️⃣ Hitung potongan voucher (kalau ada dan aktif)
            $voucherDiscount = 0;
            if ($model->voucher_applied && $model->voucher_percent > 0) {
                $voucherDiscount = $model->price_after_discount * ($model->voucher_percent / 100);
            }

            // 4️⃣ Total pendapatan akhir
            $model->total_revenue = max(0, $model->price_after_discount - $voucherDiscount);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | 💡 ACCESSOR TAMBAHAN (untuk tampilan)
    |--------------------------------------------------------------------------
    */

    public function getFormattedRevenueAttribute()
    {
        return 'Rp ' . number_format($this->total_revenue, 0, ',', '.');
    }
}
