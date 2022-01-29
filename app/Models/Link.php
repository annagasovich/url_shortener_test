<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function stats()
    {
        return $this->hasMany(Stats::class);
    }

    public function unique_stats()
    {
        return $this->hasMany(Stats::class);
    }
}
