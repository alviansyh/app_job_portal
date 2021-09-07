<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    // public function active_jobs()
    // {
    //     return $this->hasMany(Job::class)->whereStatus(1)->where('deadline', '>=', date('Y-m-d') . ' 00:00:00');
    // }

    // public function getCategoryNameAttribute($value)
    // {
    //     update_option('category_count_cached', time());
    //     $last_cached = (int) get_option('category_count_cached');
    //     $refresh_time = $last_cached + (60 * 60);

    //     if ($refresh_time < time()) {
    //         $this->job_count = $this->active_jobs->count();
    //         $this->save();

    //         update_option('category_count_cached', time());
    //     }
        
    //     return $value;
    // }
}
