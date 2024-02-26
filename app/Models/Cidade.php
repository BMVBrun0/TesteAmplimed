<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'cidade';

    // Define the relationship with Clima
    public function climas()
    {
        return $this->hasOne(Clima::class, 'cidade_id');
    }
}
