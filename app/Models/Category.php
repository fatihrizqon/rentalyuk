<?php

namespace App\Models;
 
use Illuminate\Support\Str;
use App\Models\{Vehicle, Booking};
use Kyslik\ColumnSortable\Sortable;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name', 'image', 'slug'
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->name = Str::title($category->name);
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->name = Str::title($category->name);
            $category->slug = Str::slug( $category->name);
        });
    }

    public function vehicles()
    {
      return $this->hasMany(Vehicle::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Vehicle::class);
    }
}
