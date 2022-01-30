<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    protected $table = 'stats';

    protected $guarded = ['id'];

    protected $visible = ['ip', 'user_agent', 'link'];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function link()
    {
        return $this->belongsTo(Link::class, 'url_id')->active();
    }
}
