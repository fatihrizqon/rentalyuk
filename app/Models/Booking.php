<?php

namespace App\Models;

use App\Models\User;
use App\Models\Vehicle;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'code',
        'user_id',
        'vehicle_id',
        'from',
        'to',
        'price',
        'status'
    ];
    
    public function vehicle()
    {
      return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
