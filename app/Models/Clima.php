<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clima extends Model
{
    protected $table = 'clima';
    
    public function clima()
    {
        return $this->hasMany(Clima::class);
    }
    
}
