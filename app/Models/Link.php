<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $guarded = ['id'];

    public $hidden = ['id', 'is_active', 'created_at', 'updated_at'];

    public $timestamps = false;

    public function stats()
    {
        return $this->hasMany(Stats::class);
    }

    public function unique_stats()
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
            $link->short_url = self::generateHash();
        });
    }

    private static function generateHash()
    {
        $hash = substr(uniqid(), 8);
/*        do{
            $check = self::where('x', $hash);
            $hash = substr(uniqid(), 13 - LENGTH);
        } while ($check);*/
        return $hash;
    }
}
