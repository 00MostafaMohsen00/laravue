<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
    ];

    protected $appends = [
        'image_url'
    ];

    public function listeing()
    {
        return $this->belongsTo(Listeing::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->attributes['filename']);
    }
}
