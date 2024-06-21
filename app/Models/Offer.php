<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listeing_id',
        'amount',
        'accepted_at',
        'rejected_at',
    ];

    public function listeing()
    {
        return $this->belongsTo(Listeing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
