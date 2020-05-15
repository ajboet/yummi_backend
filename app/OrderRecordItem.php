<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class OrderRecordItem extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'order_record_id', 'product_id', 'price', 'quantity',
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
     * Get the price converted with parent's currency exchange rate.
     *
     * @return string
     */
    public function getPriceAttribute()
    {
        $eRate=$this->orderRecord()
                    ->select('currency_rate')
                    ->where('id',$this->order_record_id)
                    ->setEagerLoads([])
                    ->first();
        return round($this->attributes['price'] * $eRate->currency_rate, 2);
    }
    
    /*
     * Order Record (Relationship)
    */
    public function orderRecord()
    {
        return $this->belongsTo('App\OrderRecord');
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
