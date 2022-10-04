<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashflow extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'code',
        'name',
        'user_id',
        'type',
        'value'
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($cashflow) {
            $cashflow->code = Str::upper(Str::random(6)) . Carbon::now()->format('YmdHis');
            $cashflow->user_id = Auth::user()->id;
        });
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
