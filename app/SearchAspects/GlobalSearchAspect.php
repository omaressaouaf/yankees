<?php

namespace App\SearchAspects;

use App\Models\Meal;
use App\Models\User;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Category;
use Spatie\Searchable\Search;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class GlobalSearchAspect  extends SearchAspect
{
    public function getResults(string $term): Collection
    {
        return collect((new Search())
            ->registerModel(User::class, 'name', 'email', 'phone')
            ->registerModel(Category::class, 'name', 'slug')
            ->registerModel(Extra::class, 'name', 'label', 'title')
            ->registerModel(Meal::class, 'title', 'desc')
            ->registerModel(Order::class, 'email', 'phone', 'address_line', 'address_details', 'name_on_card', 'payment_mode', 'status'));
    }
}
