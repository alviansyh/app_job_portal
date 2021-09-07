<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'name',
        'email',
        'user_type',
        'password',
        'active_status',
        'last_login_at',
        'last_login_ip',
    ];

    public function company_info()
    {
        return $this->hasOne(CompanyInfo::class)->orderBy('id', 'desc');
    }

    public function user_info()
    {
        return $this->hasOne(UserInfo::class)->orderBy('id', 'desc');
    }

    public function user_files()
    {
        return $this->hasMany(UserFile::class)->orderBy('id', 'desc');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class)->orderBy('id', 'desc');
    }

    public function show_msg_validation()
    {
        if ($this->user_type === 'employer') {
            if ($this->status_validation === 1) {
                return "Pending";
            } elseif ($this->status_validation === 2) {
                return;
            } elseif ($this->status_validation === 3) {
                return "Blocked";
            }
        } else {
            return false;
        }
    }

    public function is_user()
    {
        return $this->user_type === 'user';
    }

    public function is_employer()
    {
        return $this->user_type === 'employer';
    }

    public function is_admin()
    {
        return $this->user_type === 'admin';
    }

    public function is_sysadmin()
    {
        return $this->user_type === 'sysadmin';
    }

    public function scopeUser($query)
    {
        return $query->whereUserType('user');
    }

    public function scopeEmployer($query)
    {
        return $query->whereUserType('employer');
    }

    public function scopeAdmin($query)
    {
        return $query->whereUserType('admin');
    }

    public function scopeSysAdmin($query)
    {
        return $query->whereUserType('sysadmin');
    }

    public function isEmployerFollowed($employer_id = null)
    {
        if (!$employer_id || !Auth::check()) {
            return false;
        }

        $user = Auth::user();
        $isFollowed = UserFollowingEmployer::whereUserId($user->id)->whereEmployerId($employer_id)->first();

        if ($isFollowed) {
            return true;
        }
        return false;
    }

    public function getFollowersAttribute()
    {
        $followersCount = UserFollowingEmployer::whereEmployerId($this->id)->count();
        if ($followersCount) {
            return number_format($followersCount);
        }
        return 0;
    }

    public function getFollowableAttribute()
    {
        if (!Auth::check()) {
            return true;
        }

        $user = Auth::user();
        return $this->id !== $user->id;
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/uploads/images/logos/' . $this->logo);
        }
        return asset('assets/images/company.png');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getPremiumJobsBalanceAttribute($value)
    {
        return $value;
    }

    public function checkJobBalace()
    {
        $totalPremiumJobsPaid = $this->payments()->success()->sum('premium_job');
        $totalPosted = $this->jobs()->whereIsPremium(1)->count();
        $balance = $totalPremiumJobsPaid - $totalPosted;

        $this->premium_jobs_balance = $balance;
        $this->save();
    }

    public function signed_up_datetime()
    {
        $created_date_time = $this->created_at->timezone(get_option('default_timezone'))->format(get_option('date_format_custom') . ' ' . get_option('time_format_custom'));
        return $created_date_time;
    }

    public function status_context()
    {
        $status = $this->active_status;

        $context = '';
        switch ($status) {
            case '0':
                $context = 'Pending';
                break;
            case '1':
                $context = 'Active';
                break;
            case '2':
                $context = 'Block';
                break;
        }
        return $context;
    }
}
