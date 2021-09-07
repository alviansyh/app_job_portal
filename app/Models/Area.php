<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function company_infos()
    {
        return $this->hasMany(CompanyInfo::class);
    }

    public function user_infos()
    {
        return $this->hasMany(UserInfo::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
