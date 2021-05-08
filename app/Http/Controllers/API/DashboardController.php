<?php

namespace App\Http\Controllers\API;

use App\Models\Meal;
use App\Models\User;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Section;
use App\Models\Category;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class DashboardController extends Controller
{
    public function count()
    {
        $revenuCount = Order::sum('total');
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $extrasCount = Extra::count();
        $mealsCount = Meal::count();
        $ordersCount = Order::count();
        $sectionsCount = Section::count();
        return response()->json([
            "revenueCount" => $revenuCount,
            'usersCount' => $usersCount,
            'categoriesCount' => $categoriesCount,
            "extrasCount" => $extrasCount,
            'mealsCount' => $mealsCount,
            'ordersCount' => $ordersCount,
            "sectionsCount" => $sectionsCount,
        ]);
    }
    public function charts()
    {
        if (App::isLocale('fr')) {
            DB::statement(DB::raw("SET lc_time_names = 'fr_FR'"));
        }

        $ordersByMonth = DB::table('orders')->selectRaw("
        count(id) AS total,
        DATE_FORMAT(created_at, '%m') AS month,
        MONTHNAME(created_at) AS month
    ")
            ->groupBy('month')
            ->get();

        $latestOrder = Order::latest()->first();
        $latestOrderDate = '';
        if ($latestOrder) {
            $latestOrderDate = $latestOrder->created_at;
        }

        $usersByMonth = DB::table('users')->selectRaw("
            count(id) AS total,
            DATE_FORMAT(created_at, '%m') AS month,
            MONTHNAME(created_at) AS month
        ")

            ->groupBy('month')
            ->get();


        $latestUsers = User::latest()->take(4)->get();
        $revenueByMonth = DB::table('orders')->selectRaw("
            sum(total) AS total,
            DATE_FORMAT(created_at, '%m') AS month,
            MONTHNAME(created_at) AS month
        ")

            ->groupBy('month')
            ->get();

        return response()->json([
            'ordersByMonth' => $ordersByMonth,
            'usersByMonth' => $usersByMonth,
            'revenueByMonth' => $revenueByMonth,
            "latestOrderDate" => $latestOrderDate,
            "latestUsers" => $latestUsers

        ]);
    }
    public function globalSearch()
    {
        $results = (new Search())
            ->registerModel(User::class, 'name', 'email', 'phone')
            ->registerModel(Category::class, 'name', 'slug')
            ->registerModel(Extra::class, 'name', 'label', 'title')
            ->registerModel(Meal::class, 'title', 'desc')
            ->registerModel(Order::class, 'email', 'phone', 'address_line', 'address_details', 'name_on_card', 'payment_mode', 'status')
            ->search(request('query'));
        $resultsByType = $results->groupByType();
        /** custom pagination (the package does not include it by default) */
        foreach ($resultsByType as $key => $value) {
            $resultsByType[$key] = array_slice($value->toArray(), 0, 3);
        }
        return response()->json([
            'results' => $resultsByType
        ]);
    }
}
