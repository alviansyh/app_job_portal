<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Country;
use App\Models\UserFile;
use App\Models\CompanyInfo;
use App\Models\UserInfo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->is_employer()) {
            $company_info = CompanyInfo::whereUserId($user->id)->first();
            $user_files = UserFile::whereUserId($user->id)->first();

            if (!empty($company_info->logo)) {
                $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
            } else {
                $path_logo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.dashboard'),
                'company' => $company_info->company,
                'name' => $user->name,
                'path_avatar' => $path_logo,
                'active_jobs' => Job::whereCompanyId($company_info->id)->active()->count(),
                'total_jobs' => Job::whereCompanyId($company_info->id)->count(),
                'total_applicants' => "0",
            ];

            switch ($company_info->status_validation) {
                case 0:
                    $link = route('new_validation');
                    $html = "<a href=\"$link\" class=\"alert-link\" style=\"color: #664d03;\">disini</a>.";
                    Session::flash('warning-dashboard', trans('app.warning_validation') . $html);
                    break;
                case 1:
                    Session::flash('info-dashboard', trans('app.waiting_approval'));
                    break;
                case 3:
                    $link = route('edit_validation', Crypt::encrypt($user_files->id, true));
                    $html = "<a href=\"$link\" class=\"alert-link\">disini</a>.";
                    Session::flash('error-dashboard', trans('app.blocked_validation') . $html);
                    break;
            }

            if ($company_info->check_mandatory()) {
                $link = route('profile_settings');
                $html = "<a href=\"$link\" class=\"alert-link\" style=\"color: #664d03;\">disini</a>.";
                Session::flash('warning-mandatory', trans('app.warning_mandatory') . $html);
            }
        } elseif ($user->is_user()) {
            $user_info = UserInfo::whereUserId($user->id)->first();
            if (!empty($user_info->photo)) {
                $path_photo = url('storage/uploads/photos/photo_profile/' . $user_info->photo);
            } else {
                $path_photo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.dashboard'),
                'company' => '',
                'name' => $user->name,
                'path_avatar' => $path_photo,
                'active_jobs' => '',
                'total_jobs' => '',
                'total_applicants' => '',
            ];
        }

        \LogActivity::store(trans('app.dashboard'));
        return view('user.dashboard', $data)->with(compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();

        $countries = Country::all();
        $old_country = false;

        \LogActivity::store(trans('app.profile_settings'));

        if ($user->is_employer()) {
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
                'title' => trans('app.profile_settings'),
                'company' => $company_info->company,
                'name' => $user->name,
                'path_avatar' => $path_logo,
                'is_employer' => $user->is_employer(),
                'is_user' => $user->is_user(),
                'company_info' => $company_info,
            ];

            return view('user.profile.edit', $data)->with(compact('user', 'countries', 'old_country'));
        } elseif ($user->is_user()) {
            $user_info = $user->user_info;

            $country_id = (!empty($user_info->country_id)) ? $user_info->country_id : 1;

            if ($country_id) {
                $old_country = Country::find($country_id);
            }

            if (!empty($user_info->photo)) {
                $path_photo = url('storage/uploads/photos/photo_profile/' . $user_info->photo);
            } else {
                $path_photo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.profile_settings'),
                'company' => '',
                'name' => $user->name,
                'path_avatar' => $path_photo,
                'is_employer' => $user->is_employer(),
                'is_user' => $user->is_user(),
                'user_info' => $user_info,
            ];

            return view('user.profile.edit', $data)->with(compact('user', 'countries', 'old_country'));
        }
    }

    public function editProfilePost(Request $request)
    {
        $user = Auth::user();

        if ($user->is_employer()) {
            $rules = [
                'company_size' => 'required',
                'address' => 'required',
                'country' => 'required',
                'area' => 'required',
            ];

            $this->validate($request, $rules);

            $data_user = [
                'name' => $request->name,
            ];

            $data_company = [
                'company_size' => $request->company_size,
                'phone' => $request->phone,
                'address' => $request->address,
                'address_2' => $request->address_2,
                'postal_code' => $request->postal_code,
                'country_id' => $request->country,
                'area_id' => $request->area,
                'city' => $request->city,
                'about_company' => $request->about_company,
                'website' => $request->website,
            ];

            $user->update($data_user);
            CompanyInfo::where('user_id', $user->company_info->user_id)->update($data_company);

            \LogActivity::store(trans('app.profile_settings'));

            return back()->with('success', __('app.updated'));
        } elseif ($user->is_user()) {
            $rules = [
                'name' => 'required',
                'gender' => 'required',
                'date_birthday' => 'required',
                'country' => 'required',
                'area' => 'required',
            ];

            $this->validate($request, $rules);

            $data_user = [
                'name' => $request->name,
            ];

            $data_user_info = [
                'gender' => $request->gender,
                'date_birthday' => $request->date_birthday, 
                'phone' => $request->phone,
                'address' => $request->address,
                'address_2' => $request->address_2,
                'postal_code' => $request->postal_code,
                'country_id' => $request->country,
                'area_id' => $request->area,
                'city' => $request->city,
                'about_me' => $request->about_me,
            ];

            $user->update($data_user);
            UserInfo::where('user_id', $user->user_info->user_id)->update($data_user_info);

            \LogActivity::store(trans('app.profile_settings'));

            return back()->with('success', __('app.updated'));
        }
    }

    public function changePassword()
    {
        $user = Auth::user();
        \LogActivity::store(trans('app.change_password'));

        if ($user->is_employer()) {
            $company_info = $user->company_info;

            if (!empty($company_info->logo)) {
                $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
            } else {
                $path_logo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.change_password'),
                'company' => $company_info->company,
                'name' => Auth::user()->name,
                'path_avatar' => $path_logo,
            ];
        } elseif ($user->is_user()) {
            $user_info = $user->user_info;

            if (!empty($user_info->photo)) {
                $path_photo = url('storage/uploads/photos/photo_profile/' . $user_info->photo);
            } else {
                $path_photo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.change_password'),
                'company' => '',
                'name' => Auth::user()->name,
                'path_avatar' => $path_photo,
            ];
        }

        return view('auth.passwords.change', $data);
    }

    public function changePasswordPost(Request $request)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ];

        $this->validate($request, $rules);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        if (Auth::check()) {
            $logged_user = Auth::user();

            if (Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                \LogActivity::store(trans('app.change_password'));
                return redirect()->back()->with('success', trans('app.password_changed_msg'));
            }
            return redirect()->back()->with('error', trans('app.wrong_old_password'));
        }
    }
}
