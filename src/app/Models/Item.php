<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['explorer_id', 'name', 'value', 'latitude', 'longitude'];

    public function explorer()
    {
        return $this->belongsTo(Explorer::class);
    }
}
