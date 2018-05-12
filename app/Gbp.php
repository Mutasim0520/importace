<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gbp extends Model
{
    protected $fillable = [
        'rate', 'dlv_charge', 'shipping_cost','upper','lower',
    ];
}
