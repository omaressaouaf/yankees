<?php

namespace App\Models;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Category extends Model implements Searchable
{
    use HasFactory;
    protected $guarded = [];

    public function getSearchResult(): SearchResult
    {
       $url = "/categories/" . $this->id;
        return new SearchResult(
           $this,
           $this->name,
           $url
        );
    }
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
    protected static function booted()
    {
        static::created(function ($category) {
            $category->order = $category->id;
            $category->save();
        });
    }
}
