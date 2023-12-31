<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}
