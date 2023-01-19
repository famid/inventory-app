<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'subcategory_id',
        'category_id',
        'price',
        'thumbnail'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function subcategory(): BelongsTo {
        return $this->belongsTo(Subcategory::class);
    }

}
