<?php

namespace App\Models;
 
use App\Models\{Vehicle, Booking};
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name', 'image', 'slug'
    ];

    public function vehicles()
    {
      return $this->hasMany(Vehicle::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Vehicle::class);
    }
}
