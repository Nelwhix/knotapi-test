<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'card_number',
        'cvv',
        'expiration',
        'user_id'
    ];

    public function user() {
        $this->belongsTo(User::class);
    }
}
