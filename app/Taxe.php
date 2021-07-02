<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    public function sale()
    {
        return $this->hasOne(Sale::class);
    }
}
