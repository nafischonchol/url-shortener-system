<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortenUrl extends Model
{
    protected $fillable = ["user_id",'long_url', 'shortened_url',"clicks"];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
