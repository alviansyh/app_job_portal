<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'deadline',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function company_info()
    {
        return $this->belongsTo(CompanyInfo::class);
    }

    public function job_applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function job_category()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', '=', 0)->where('deadline', '>=', date('Y-m-d') . ' 00:00:00');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', '=', 1)->where('deadline', '>=', date('Y-m-d') . ' 00:00:00');
    }

    public function scopeExpired($query)
    {
        return $query->where('deadline', '<=', date('Y-m-d') . ' 00:00:00');
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', '=', 2)->where('deadline', '>=', date('Y-m-d') . ' 00:00:00');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1)->where('deadline', '>=', date('Y-m-d') . ' 00:00:00');
    }

    public function scopePremium($query)
    {
        return $query->whereIsPremium(1);
    }

    public function nl2ulformat($string = null)
    {
        if (!$string) {
            return '';
        }
        $array = explode("\n", $string);
        $output = '';
        if (is_array($array) && count($array)) {
            $output .= '<ul>';
            foreach ($array as $item) {
                $output .= '<li class="mb-2">' . $item . '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }

    public function is_active()
    {
        return $this->status == 1;
    }

    public function is_pending()
    {
        return $this->status == 0;
    }

    public function can_edit()
    {
        $viewable = false;

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_admin() || $user->id == $this->user_id) {
                $viewable = true;
            }
        }

        return $viewable;
    }

    public function status_context()
    {
        $status = $this->status;
        $html = '';
        switch ($status) {
            case 0:
                $html = '<span class="badge badge-pill bg-warning-light">' . trans('app.pending') . '</span>';
                break;
            case 1:
                $html = '<span class="badge badge-pill bg-success-light">' . trans('app.published') . '</span>';
                break;
            case 2:
                $html = '<span class="badge badge-pill bg-danger-light">' . trans('app.blocked') . '</span>';
                break;
        }
        return $html;
    }
}
