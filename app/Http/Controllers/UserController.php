<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $title = trans('app.users');
        $current_user = Auth::user();
        $users = User::where('id', '!=', $current_user->id)->orderBy('name', 'asc')->paginate(20);
        return view('admin.users', compact('title', 'users'));
    }

    public function show($id = 0)
    {
        if ($id) {
            $title = trans('app.profile');
            $user = User::find($id);

            $is_user_id_view = true;
            return view('admin.profile', compact('title', 'user', 'is_user_id_view'));
        }
    }

    public function registerJobSeeker()
    {
        $title = __('app.register_jobseeker');
        return view('register_jobseeker', compact('title'));
    }

    public function registerJobSeekerPost(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
        ];

        $this->validate($request, $rules);

        $user_id = generate_id('users', 'id', 10, date('ym'), true);

        User::create([
            'id' => $user_id,
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'user',
            'password' => Hash::make($request->password),
            'active_status' => 1,
        ]);

        UserInfo::create([
            'id' => generate_id('user_infos', 'id', 10, date('ym'), true),
            'user_id' => $user_id,
        ]);

        return redirect(route('login'))->with('success', __('app.registration_successful_msg'));
    }

    public function registerEmployer()
    {
        $title = __('app.register_employer');
        return view('register_employer', compact('title'));
    }

    public function registerEmployerPost(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:191'],
            'company' => 'required',
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
        ];
        $this->validate($request, $rules);

        $company = $request->company;
        $company_slug = unique_slug($company, 'CompanyInfo', 'company_slug');

        $user_id = generate_id('users', 'id', 10, date('ym'), true);

        User::create([
            'id' => $user_id,
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'employer',
            'password' => Hash::make($request->password),
            'active_status' => 1,
        ]);

        CompanyInfo::create([
            'id' => generate_id('company_infos', 'id', 10, date('ym'), true),
            'user_id' => $user_id,
            'company' => $company,
            'company_slug' => $company_slug,
        ]);

        return redirect(route('login'))->with('success', __('app.registration_successful_msg'));
    }
}
