<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
