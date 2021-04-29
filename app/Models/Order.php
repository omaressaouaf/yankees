<?php

namespace App\Models;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    public function deliveryman()
    {
        return $this->belongsTo(User::class , 'deliveryman_id');
    }
    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot(['qty', 'meal_subtotal', 'user_selected_options']);
    }
    public  function detailsWithRemovedMeals()
    {
        /*
        this method checks if a deleted meal is present in the Order details
        (meal_id field in meal_order table would be null in this case) .
        if so :  it pushes a new object (the deleted Meal) to the $orderDetails collection
        in order to let the user know that his order contains some deleted meals (user Friendly) :)
        */
        $MealOrderRelationShipItems = MealOrder::where('order_id', $this->id)->get();
        $orderMeals = $this->meals;
        foreach ($MealOrderRelationShipItems as $item) {
            if ($item->meal_id == null) {
                $orderMeals->push((object)array(
                    'id' => null,
                    'resizedImage' => "/storage/images/meals/noimage.jpg",
                    'pivot' => (object)array(
                        'qty' => $item->qty,
                        'meal_subtotal' => $item->meal_subtotal,
                        "user_selected_options" => $item->user_selected_options
                    ),
                    'title' => __('Unknown'),
                ));
            }
        }
        return $orderMeals;
    }
}
