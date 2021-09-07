<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function uploadImage(Request $request)
    {
        $user = Auth::user();
        if ($request->hasFile('file_upload')) {

            if ($user->is_employer()) {
                $company_info = $user->company_info;
                $image = $request->file('file_upload');

                $resized_image = Image::make($image)->resize(null, 256, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream();

                $company_logo = $company_info->company_slug . '.' . $image->getClientOriginalExtension();
                $company_logo_path = 'uploads/photos/company_logo/' . $company_logo;

                Storage::disk('public')->put($company_logo_path, $resized_image->__toString());
                $data['logo'] = $company_logo;

                CompanyInfo::where('user_id', $company_info->user_id)->update($data);
                Session::flash('success', __('app.updated_logo'));

                \LogActivity::store(trans('app.updated_logo'));

                return ['success' => true, 'msg' => trans('app.updated_logo')];
            } elseif ($user->is_user()) {
            }
        }
    }

    public function downloadImage(Request $request)
    {
    }

    public function showImage(Request $request)
    {
        if ($request->hasFile('file_upload')) {
            
        }
    }

    public function uploadFile(Request $request)
    {
        # code...
    }
}
