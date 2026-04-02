<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    public $incrementing = false;
    protected $keyType = 'int';

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
