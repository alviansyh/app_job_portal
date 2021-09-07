<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->is_employer()) {
                $company_info = $user->company_info;

                if (!empty($company_info->logo)) {
                    $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
                } else {
                    $path_logo = url('storage/uploads/photos/profile-placeholder.png');
                }

                $data = [
                    'title' => trans('app.dashboard'),
                    'path_avatar' => $path_logo,
                ];
            } elseif ($user->is_user()) {
                $user_info = $user->user_info;

                if (!empty($user_info->photo)) {
                    $path_photo = url('storage/uploads/photos/company_logo/' . $user_info->photo);
                } else {
                    $path_photo = url('storage/uploads/photos/profile-placeholder.png');
                }

                $data = [
                    'title' => trans('app.dashboard'),
                    'path_avatar' => $path_photo,
                ];
            }
        }

        $categories = JobCategory::orderBy('category_name', 'asc')->get();
        return view('home', $data)->with(compact('categories'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Clear all cache
     */
    public function clearCache()
    {
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        if (function_exists('exec')) {
            exec('rm ' . storage_path('logs/*'));
        }
        return redirect(route('home'));
    }
}
