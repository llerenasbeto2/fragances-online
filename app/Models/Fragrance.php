<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fragrance extends Model
{
     use HasFactory;

    protected $fillable = [
        'brand_id',
        'collection_id',
        'name',
        'description',
        'price',
        'image_url',
        'stock',
        'concentration',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
