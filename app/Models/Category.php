<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    use HasFactory;
    use HasSlug;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];


    protected $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'slug', 'is_active','name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['translations'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }
    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }

    public function getActive(){
        return  $this -> is_active  == 1 ?  __('data.Active')   : __('data.Not active') ;
    }

    public static function active()
    {
        $Categories = Category::where('is_active' , '=', 1)->get();
        return $Categories;
    }

    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    /*
     * ID = The parent id
     */
    public function getSubCategories($id)
    {
       return Category::where(['parent_id' => $id, 'is_active' => true])->get();
    }


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

}
