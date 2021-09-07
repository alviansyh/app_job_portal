<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
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

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function show_status_validation()
    {
        //TRUE/FALSE : Menampilkan warning siup atau tidak
        if ($this->validation_number != null) {
            return true;
        } else {
            return false;
        }
    }

    public function check_mandatory()
    {
        if ($this->company_size != null && $this->address != null && $this->country_id != null && $this->area_id != null && $this->about_company != null) {
            return false;
        } else {
            return true;
        }
    }

    public function validation_context()
    {
        $status = $this->status_validation;
        $html = '';
        switch ($status) {
            case 1:
                $html = '<span class="badge badge-pill bg-warning-light">' . trans('app.evaluating') . '</span>';
                break;
            case 2:
                $html = '<span class="badge badge-pill bg-success-light">' . trans('app.approved') . '</span>';
                break;
            case 3:
                $html = '<span class="badge badge-pill bg-danger-light">' . trans('app.blocked') . '</span>';
                break;
        }
        return $html;
    }
    public function validation_status()
    {
        $status = $this->status_validation;
        $html = '';
        switch ($status) {
            case 1:
                $html = '<strong>' . trans('app.evaluating') . '</strong>';
                break;
            case 2:
                $html = '<strong>' . trans('app.approved') . '</strong>';
                break;
            case 3:
                $html = '<strong>' . trans('app.blocked') . '</strong>';
                break;
        }
        return $html;
    }
}
