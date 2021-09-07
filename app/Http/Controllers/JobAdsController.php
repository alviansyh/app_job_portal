<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\Option;
use App\Models\Country;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;

class JobAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $company_info = $user->company_info;
        if (!empty($company_info->logo)) {
            $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
        } else {
            $path_logo = url('storage/uploads/photos/profile-placeholder.png');
        }

        $approved_jobs = Job::approved()->orderBy('id', 'desc')->get();
        $pending_jobs = Job::pending()->orderBy('id', 'desc')->get();
        $expired_jobs = Job::expired()->orderBy('id', 'desc')->get();
        $blocked_jobs = Job::blocked()->orderBy('id', 'desc')->get();

        $data = [
            'title' => trans('app.job_ads'),
            'company' => $company_info->company,
            'name' => $user->name,
            'path_avatar' => $path_logo,
            'is_employer' => $user->is_employer(),
            'is_user' => $user->is_user(),
            'approved_jobs' => $approved_jobs,
            'expired_jobs' => $expired_jobs,
            'pending_jobs' => $pending_jobs,
            'blocked_jobs' => $blocked_jobs,
        ];

        return View::make('user.job_ads.index', $data)->with(compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $categories = JobCategory::orderBy('category_name', 'asc')->get();
        $countries = Country::all();
        $old_country = false;

        $company_info = $user->company_info;
        $country_id = (!empty($company_info->country_id)) ? $company_info->country_id : 1;

        if ($country_id) {
            $old_country = Country::find($country_id);
        }

        if (!empty($company_info->logo)) {
            $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
        } else {
            $path_logo = url('storage/uploads/photos/profile-placeholder.png');
        }

        $data = [
            'title' => trans('app.post_new_job'),
            'company' => $company_info->company,
            'name' => $user->name,
            'path_avatar' => $path_logo,
            'is_employer' => $user->is_employer(),
            'is_user' => $user->is_user(),
            'company_info' => $company_info,
        ];

        return View::make('user.job_ads.create', $data)->with(compact('user', 'countries', 'old_country', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $company_info = $user->company_info;

        if ($company_info->status_validation != 2) {
            $status = 0;
        } else {
            $status = 1;
        }

        $rules = [
            'job_title' => ['required', 'string', 'max:190'],
            'skills' => 'required',
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ];

        $this->validate($request, $rules);

        $job_title = $request->job_title;
        $job_slug = unique_slug($job_title, 'Job', 'job_slug');

        $job_id = strtoupper(str_random(8));
        $salary_currency = 'IDR';

        $data = [
            'company_id' => $company_info->id,
            'job_title' => $job_title,
            'job_slug' => $job_slug,
            'position' => $request->position,
            'skills' => $request->skills,
            'category_id' => $request->category,
            'job_type' => $request->job_type,
            'gender' => $request->gender,
            'exp_level' => $request->exp_level,
            'experience_required_years' => $request->experience_required_years,
            'min_exp' => $request->min_exp,
            'deadline' => $request->deadline,

            'description' => $request->description,
            'qualification' => $request->qualification,
            'benefits' => $request->benefits,

            'country_id' => $request->country,
            'area_id' => $request->area,
            'city_name' => $request->city_name,

            'vacancy' => $request->vacancy,
            'salary_cycle' => $request->salary_cycle,
            'salary' => $request->salary,
            'is_negotiable' => $request->is_negotiable,
            'salary_upto' => $request->salary_upto,

            'salary_currency' => $salary_currency,
            'status' => $status,
        ];

        $job = Job::create($data);
        if (!$job) {
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }

        $job->update(['job_id' => $job->id . $job_id]);
        if ($company_info->status_validation != 2) {
            return redirect()->route('job_ads')->with('warning', __('app.warning_job_posted_success'));
        } else {
            return redirect()->route('job_ads')->with('success', __('app.job_posted_success'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function find($slug)
    {
        $data = [];
        $job = Job::whereJobSlug($slug)->first();

        $company_info = $job->company_info;

        $title = $job->job_title;
        $company = $company_info->company;
        if (!empty($company_info->logo)) {
            $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
        } else {
            $path_logo = url('storage/uploads/photos/profile-placeholder.png');
        }

        if (!$slug || !$job || (!$job->is_active() && !$job->can_edit())) {
            abort(404);
        }

        $data = [
            'title' => $title,
            'path_avatar' => $path_logo,
            'company' => $company,
            'location' => $company_info->areas->area_name . ", " . $company_info->countries->country_name,
        ];

        return View::make('job_view', $data)->with(compact('job', 'company_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (JobApplication::whereJobId($id)->count() != 0) {
            $user = Auth::user();

            $categories = JobCategory::orderBy('category_name', 'asc')->get();
            $countries = Country::all();
            $old_country = false;

            $company_info = $user->company_info;
            $job_ads = Job::whereJobId($id)->first();

            if ($company_info->country_id) {
                $old_country = Country::find($company_info->country_id);
            }

            if (!empty($company_info->logo)) {
                $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
            } else {
                $path_logo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.post_new_job'),
                'company' => $company_info->company,
                'name' => $user->name,
                'path_avatar' => $path_logo,
                'is_employer' => $user->is_employer(),
                'is_user' => $user->is_user(),
                'job_ads' => $job_ads,
            ];

            return View::make('user.job_ads.edit', $data)->with(compact('user', 'countries', 'old_country', 'categories'));
        } else {
            return redirect()->route('job_ads')->with('warning', __('app.edit_job_warning'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $company_info = $user->company_info;
        $job_ads = Job::whereJobId($id)->first();

        if ($company_info->status_validation != 2) {
            $status = 0;
        } else {
            $status = 1;
        }

        $rules = [
            'job_title' => ['required', 'string', 'max:190'],
            'skills' => 'required',
            'category' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ];

        $this->validate($request, $rules);

        $job_title = $request->job_title;
        $job_slug = unique_slug($job_title, 'Job', 'job_slug');

        $data = [
            'company_id' => $company_info->id,
            'job_title' => $job_title,
            'job_slug' => $job_slug,
            'position' => $request->position,
            'skills' => $request->skills,
            'category_id' => $request->category,
            'job_type' => $request->job_type,
            'gender' => $request->gender,
            'exp_level' => $request->exp_level,
            'experience_required_years' => $request->experience_required_years,
            'min_exp' => $request->min_exp,
            'deadline' => $request->deadline,

            'description' => $request->description,
            'qualification' => $request->qualification,
            'benefits' => $request->benefits,

            'country_id' => $request->country,
            'area_id' => $request->area,
            'city_name' => $request->city_name,

            'vacancy' => $request->vacancy,
            'salary_cycle' => $request->salary_cycle,
            'salary' => $request->salary,
            'is_negotiable' => $request->is_negotiable,
            'salary_upto' => $request->salary_upto,

            'status' => $status,
        ];

        $job_ads->update($data);

        return redirect()->route('job_ads')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (JobApplication::whereJobId($id)->count() == 0) {
            $job = Job::where('job_id', $id);
            $job->delete();
            return redirect()->route('job_ads')->with('success', __('app.delete_job_success'));
        } else {
            return redirect()->route('job_ads')->with('warning', __('app.delete_job_warning'));
        }
    }
}
