<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class OrderRecord extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_record';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subtotal', 'discount', 'discount_percentage', 'shipping_charges',
        'net_total', 'tax', 'total', 'round_off', 'payable',
    ];

    /**
     * Make softdeletes available for this model.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The relationships that should be eager loaded.
     *
     * @var array
     */
    protected $with = [
        'items'
    ];

    /*
     * Get a field converted with currency exchange rate.
    */
    private function convertRate($field_value)
    {
        return round($field_value * $this->attributes['currency_rate'], 2);
    }

    /**
     * Get the subtotal converted.
     *
     * @return string
     */
    public function getSubtotalAttribute()
    {
        return Self::convertRate($this->attributes['subtotal']);
    }

    /**
     * Get the discount converted.
     *
     * @return string
     */
    public function getDiscountAttribute()
    {
        return Self::convertRate($this->attributes['discount']);
    }

    /**
     * Get the discount_percentage converted.
     *
     * @return string
     */
    public function getDiscountPercentageAttribute()
    {
        return Self::convertRate($this->attributes['discount_percentage']);
    }

    /**
     * Get the shipping_charges converted.
     *
     * @return string
     */
    public function getShippingChargesAttribute()
    {
        return Self::convertRate($this->attributes['shipping_charges']);
    }

    /**
     * Get the net_total converted.
     *
     * @return string
     */
    public function getNetTotalAttribute()
    {
        return Self::convertRate($this->attributes['net_total']);
    }

    /**
     * Get the tax converted.
     *
     * @return string
     */
    public function getTaxAttribute()
    {
        return Self::convertRate($this->attributes['tax']);
    }

    /**
     * Get the total converted.
     *
     * @return string
     */
    public function getTotalAttribute()
    {
        return Self::convertRate($this->attributes['total']);
    }

    /**
     * Get the payable converted.
     *
     * @return string
     */
    public function getPayableAttribute()
    {
        return Self::convertRate($this->attributes['payable']);
    }


    /*
     * Order Record Items (Relationship)
    */
    public function items()
    {
        return $this->hasMany('App\Models\OrderRecordItem');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:sa');
    }

}
