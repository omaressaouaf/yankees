<?php

namespace App\Models;

use App\Models\Extra;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{
    use HasFactory;
    protected $casts = [
        'active' => 'boolean'
    ];

    protected $fillable = ['title', 'desc', 'image', 'price', 'active', 'category_id'];


    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => __('Unknown')
        ]);
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class)->withPivot(['admin_selected_options', 'min', 'max'])->using(ExtraMeal::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot(['qty', 'meal_subtotal', 'user_selected_options']);
    }
    public function deleteOldImages()
    {
        $path =  "/public/images/meals/" . $this->id;
        Storage::deleteDirectory($path);
    }
}
