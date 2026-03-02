<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkLogs extends Model
{

    protected $table = 'link_logs';
    protected $fillable = [
        'link_id',
        'streamer_name',
        'username',
        'link_url',
        'platform'
    ];

}
