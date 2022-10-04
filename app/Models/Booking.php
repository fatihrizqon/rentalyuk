<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, Sortable;
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $fillable = [
        'code',
        'user_id',
        'vehicle_id',
        'from',
        'to',
        'price',
        'status'
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->code = Str::upper(Str::random(6)) . Carbon::now()->format('YmdHis');
        });
    }
    
    public function vehicle()
    {
      return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
