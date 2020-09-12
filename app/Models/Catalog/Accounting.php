<?php

namespace App\Models\Catalog;

use App\Http\Resources\ImageResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class Accounting extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'product_id',
        'date',
        'status_id',
        'price',
        'message',
        'supplier_id',
        'whom',
        'amount',
        'comment'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function status():BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function supplier():BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getImagesListAttribute()
    {
        return ImageResource::collection($this->getMedia('uploads'));
    }
}
