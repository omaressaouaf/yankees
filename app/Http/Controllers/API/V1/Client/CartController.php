<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Requests\CartStoreRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Controller;


class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json([
            'content' => Cart::content()->reverse(),
            'total' => Cart::total(),
            'count' => Cart::count(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreRequest $request)
    {

        $meal = Meal::findOrFail($request->id);
        $user_selected_options = '';
        $user_selected_options_total_price = 0;
        foreach ($request->extras as $extra) {
            if (count($extra['user_selected_options'])) {
                $user_selected_options .=  '<strong>' . $extra['label'] . "</strong> : ";
            }
            foreach ($extra['user_selected_options'] as $option) {
                $user_selected_options .= $option['name'] . ' , ';
                $user_selected_options_total_price += (int)$option['price'];
            }
            $user_selected_options .= " \n ";
        }
        Cart::add(
            $meal->id,
            $meal->title,
            (int)$request->qty,
            ($user_selected_options_total_price + $meal->price),
            ['user_selected_options' => $user_selected_options]
        )->associate(Meal::class);

        return response()->json([
            'content' => Cart::content()->reverse(),
            'total' => Cart::total(),
            'count' => Cart::count()
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:20'
        ]);
        // the $id is actually the row id . just kept it $id for route resource
        Cart::update($id, $request->qty);
        return response()->json([
            'content' => Cart::content()->reverse(),

            'total' => Cart::total(),
            'count' => Cart::count()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // the $id is actually the row id . just kept it $id for route resource
        Cart::remove($id);
        return response()->json([
            'content' => Cart::content()->reverse(),
            'total' => Cart::total(),
            'count' => Cart::count()
        ]);
    }
    public function destroyAll()
    {
        Cart::destroy();
    }
}
