<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
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

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
