<?php

namespace App\Models;

use App\Models\Meal;
use App\Models\Option;
use App\Models\ExtraMeal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
class Extra extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['name','label', 'title', 'min', 'max'];

    public function getSearchResult(): SearchResult
    {
       $url = "/extras/" . $this->id;
        return new SearchResult(
           $this,
           $this->name,
           $url
        );
    }
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot(['admin_selected_options', 'min', 'max'])->using(ExtraMeal::class);
    }
}
