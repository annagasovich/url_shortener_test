<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $guarded = ['id'];

    public $hidden = ['id', 'is_active', 'created_at', 'updated_at'];

    public $timestamps = true;

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stats()
    {
        return $this->hasMany(Stats::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($link) {
            //@var $link Link
            $link->short_url = self::generateHash($link->long_url);
        });
    }

    /**
     * @param string $long_url
     * @return string
     */
    private static function generateHash(string $long_url)
    {
        do{
            $hash = substr(uniqid(), 6);
            $check = self::active()->where('short_url', $hash)->where('long_url', $long_url)->get()->count();
        } while ($check);

        return $hash;
    }
}
