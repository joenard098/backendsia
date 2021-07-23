<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'roomnumber', 
        'address', 
        'phone', 
        'quantity',
        'user_id',
    ];

    public function container() {
        return $this->belongsTo('App\Models\Reservation', 'phone', 'id');
    }
}
