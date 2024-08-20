<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;

class Order extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasStatuses;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'orderable_id',
        'orderable_type',
        'type', // Book , Tuition
        'user_id',
        'contract_number',
        'contract_type', // new_term, new_course
        'payment_type',
        'payment_method',
        'payment_status',
        'gateway',
        'tax',
        'discount_amount',
        'order_amount',
        'paid_amount',
        'register_date',
        'description',
        'renewal_number',
        'order_number',
        'total_installments',
        'installment_date',
        'installment_amount',
        'age_range',
    ];

    public function getTransStatusAttribute()
    {
        return __('admin/enums/EnumOrderPaymentStatus.' . $this->payment_status);
    }

    public function getPersianRegisterDateAttribute()
    {
        return \Morilog\Jalali\Jalalian::fromDateTime($this->register_date)->format('Y-m-d');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->order_amount - $this->paid_amount;
    }

    public function scopeBook($query)
    {
        $query->where('type', 'book');
    }

    public function scopeTuition($query)
    {
        $query->where('type', 'tuition');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orderable associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all of the orderItems for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all of the installments for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    /**
     * Get all of the transctions for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transctions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Media Conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('documents')->nonQueued();
    }
}
