<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ["user_id",'long_url', 'shortened_url',"clicks"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
