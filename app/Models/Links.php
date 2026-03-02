<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table = 'tbl_links';
    protected $primaryKey = 'id_link';
    protected $fillable = [
        'streamer_id',
        'link_url',
        'username',
        'message',
        'is_watched',
        'is_accept'
    ];
}
