<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function job_applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function user_addtional_info()
    {
        return $this->hasMany(UserAddtionalInfo::class);
    }

    public function user_education()
    {
        return $this->hasMany(UserEducation::class);
    }

    public function user_experience()
    {
        return $this->hasMany(UserExperience::class);
    }

    public function user_language()
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function user_skill()
    {
        return $this->hasMany(UserSkill::class);
    }
}
