<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
      'license_number','name','image','price','category_id','status'
    ];

    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($vehicle) {
            $vehicle->name = Str::title($vehicle->name);
            $vehicle->license_number = Str::upper($vehicle->license_number);
        });

        static::updating(function ($vehicle) {
            $vehicle->name = Str::title($vehicle->name);
            $vehicle->license_number = Str::upper($vehicle->license_number);
        });
    }

    public function scopeFilter($query, array $filters)
    {
      $query->when([$filters['from'], $filters[ 'to']] ?? false, function($query, $filters)
      {
        $filters = ['from' => $filters[0], 'to' => $filters[1]];
        return $query->whereDoesntHave('bookings', function($query) use($filters){
               $query->where('status', 1)
                     ->whereBetween('from', [$filters['from'], $filters['to']]);
        });
      });

      // bugnya ketemu, ketika pakai category filter di atas gak jalan harusnya jalan tiga tiganya (from to category)
      $query->when($filters['category'] ?? false, function($query, $category){
        return $query->whereHas('category', function($query) use($category){
          $query->where('slug', $category);
        });
      });
    }

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getRouteKeyName()
    {
      return 'license_number';
    }
}
