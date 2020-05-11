<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Product extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'details', 'price', 'image',
    ];

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
