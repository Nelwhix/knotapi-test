<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, HasUuids;

    public function user() {
        $this->belongsTo(User::class);
    }

    public function merchant() {
        $this->belongsTo(Merchant::class);
    }

    public function card() {
        $this->belongsTo(Card::class);
    }
}
