<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = ['from', 'to'];
    
    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('to', '>=', $from)
        ->where('from', '<=', $to);
    }

    public static function findByReviewKey(string $reviewKey): ?Booking //? либо класс Booking либо null
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
        //with - соединяет еще с другой сущностью, дополняя вывод данных.
        // в данном случае выведется найденная сущность booking и связная с ней bookable
    }

    protected static function boot()
    {
        parent::boot();
        //вот это вообще не понимаю, что тут происходит. 077 видео

        static::creating(function ($booking) {
            $booking->review_key = Str::uuid();
        });
        // я так понимаю при создании записи в booking добавляется review_key и заполняется uuid-ом
    }
}
