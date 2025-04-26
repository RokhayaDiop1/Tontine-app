<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'user_id',
        'tontine_id',
        'dateNaissance',
        'cni',
        'adresse',
        'imageCni',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }
}
