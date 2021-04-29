<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['line', 'details', 'latitude', 'longitude', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function inBounds($lat, $long)
    {
        $bounds = config('delivery.zone_bounds');
        $eastBound = $long < $bounds['north_east']['longitude'];
        $westBound = $long > $bounds['south_west']['longitude'];

        if ($bounds['north_east']['longitude'] < $bounds['south_west']['longitude']) {
            $inLong = $eastBound || $westBound;
        } else {
            $inLong = $eastBound && $westBound;
        }

        $inLat = $lat > $bounds['south_west']['latitude'] && $lat < $bounds['north_east']['latitude'];
        return $inLat && $inLong;
    }
}
