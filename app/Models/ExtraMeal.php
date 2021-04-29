<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExtraMeal extends Pivot
{
    protected $table='extra_meal';
    protected $casts = [
        'admin_selected_options' => 'array',
    ];
    use HasFactory;
}
