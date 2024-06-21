<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listeing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'beds',
        'baths',
        'area',
        'city',
        'code',
        'street',
        'street_nr',
        'price',
        'user_id',
        'sold_at',
    ];

    protected $sortable = [
        'beds',
        'baths',
        'price',
        'created_at',
    ];

    public function scopeMostRecent($query)
    {
        return $query->latest();
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['priceFrom'] ?? false, function ($query) use ($filters) {
            return $query->where('price', '>=', $filters['priceFrom']);
        })
            ->when($filters['priceTo'] ?? false, function ($query) use ($filters) {
                return $query->where('price', '<=', $filters['priceTo']);
            })
            ->when($filters['beds'] ?? false, function ($query) use ($filters) {
                if ($filters['beds'] >= 6) {
                    return $query->where('beds', '>=', '6');
                }
                return $query->where('beds', $filters['beds']);
            })
            ->when($filters['baths'] ?? false, function ($query) use ($filters) {
                if ($filters['baths'] >= 6) {
                    return $query->where('baths', '>=', '6');
                }
                return $query->where('baths', $filters['baths']);
            })
            ->when($filters['areaFrom'] ?? false, function ($query) use ($filters) {

                return $query->where('area', '>=', $filters['areaFrom']);
            })
            ->when($filters['areaTo'] ?? false, function ($query) use ($filters) {

                return $query->where('area', '<=',  $filters['areaTo']);
            })->when($filters['deleted'] ?? false, function ($query) use ($filters) {
                return $query->withTrashed();
            })
            ->when($filters['by'] ?? false, function ($query) use ($filters) {
                return !in_array($filters['by'], $this->sortable) ? $query : $query->orderBy($filters['by'], $filters['order'] ?? 'desc');
            });
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ListeingImage::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
