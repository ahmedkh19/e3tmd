<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOption\Option;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Product extends Model
{
    use HasFactory;
    use HasSlug;

    use Translatable,
        SoftDeletes;


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'categories',
        'pricing_method',
        'start_bid_amount',
        'auction_start',
        'auction_end',
        'price',
        'plan',
        'account_email',
        'account_email_website',
        'account_username',
        'account_password',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'isSold' => 'boolean',
    ];
    protected $dates = ['auction_start', 'auction_end'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'description', 'short_description'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function bids()
    {
        return $this->belongsToMany(Bid::class, 'bids');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'product_id');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
        ->doNotGenerateSlugsOnUpdate();

    }

    public function conversations(): hasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
