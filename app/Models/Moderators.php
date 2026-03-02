<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moderators extends Model
{
    protected $table = 'tbl_mods';
    protected $primaryKey = 'id_mod';
    protected $fillable = [
        'streamer_id',
        'mod_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'mod_id', 'id_user');
    }
}
