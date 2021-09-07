<?php

namespace App\Http\Controllers;

use View;
use Ramsey\Uuid\Uuid;
use App\Models\UserFile;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ValidationController extends Controller
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
        $user_file = UserFile::where('user_id', '=', $user->id)->where('code', '=', 'company_verify_file')->first();
        $data = [
            'title' => trans('app.account_validation'),
            'company' => $company_info->company,
            'name' => $user->name,
            'path_avatar' => $path_logo,
            'is_employer' => $user->is_employer(),
            'is_user' => $user->is_user(),
            'validation' => $user_file
        ];

        \LogActivity::store(trans('app.account_validation'));

        return View::make('user.validations.index', $data)->with(compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $company_info = $user->company_info;
        if (!empty($company_info->logo)) {
            $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
        } else {
            $path_logo = url('storage/uploads/photos/profile-placeholder.png');
        }

        $data = [
            'title' => trans('app.account_validation'),
            'company' => $company_info->company,
            'name' => $user->name,
            'path_avatar' => $path_logo,
            'is_employer' => $user->is_employer(),
            'is_user' => $user->is_user(),
        ];

        if ($company_info->status_validation != 0) {
            return redirect()->route('validation');
        } else {
            \LogActivity::store(trans('app.account_validation'));
            return View::make('user.validations.create', $data)->with(compact('user'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_whitelist  = array('jpg', 'jpeg', 'png');
        $file_whitelist  = array('pdf');
        $user = Auth::user();

        $rules = [
            'validation_number' => 'required',
        ];

        $this->validate($request, $rules);

        $data_company_info = [
            'validation_number' => $request->validation_number,
            'status_validation' => 1, //* Pending
        ];

        $company_info = CompanyInfo::where('user_id', $user->company_info->user_id)->update($data_company_info);
        if ($company_info) {
            $uuid = Uuid::uuid4()->toString();
            if ($request->hasFile('file_upload')) {
                $file = $request->file('file_upload');
                $ext = $file->getClientOriginalExtension();
                $file_name = $uuid;
                $file_id = generate_id('user_files', 'id', 10, date('ym'), true);
                switch ($ext) {
                    case in_array(strtolower($ext), $image_whitelist):
                        $resized_image = Image::make($file)->resize(null, 256, function ($constraint) {
                            $constraint->aspectRatio();
                        })->stream();

                        $file_path = 'uploads/files/' . $file_name;

                        Storage::disk('public')->put($file_path, $resized_image->__toString());
                        $data_user_file = [
                            'id' => $file_id,
                            'user_id' => $user->company_info->user_id,
                            'filename' => $file_name,
                            'filename_origin' => $file->getClientOriginalName(),
                            'code' => 'company_verify_file'
                        ];

                        $user_file = UserFile::create($data_user_file);
                        if (!$user_file) {
                            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
                        }
                        break;
                    case in_array(strtolower($ext), $file_whitelist):
                        $file_path = 'uploads/files/' . $file_name;

                        Storage::disk('public')->put($file_path, 'Contents');
                        $data_user_file = [
                            'id' => $file_id,
                            'user_id' => $user->company_info->user_id,
                            'filename' => $file_name,
                            'filename_origin' => $file->getClientOriginalName(),
                            'code' => 'company_verify_file'
                        ];

                        $user_file = UserFile::create($data_user_file);
                        if (!$user_file) {
                            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
                        }
                        break;
                }
            }
            \LogActivity::store(trans('app.account_validation'));
            return redirect()->route('validation')->with('success', __('app.validation_posted_success'));
        } else {
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id, true);
        if (UserFile::whereId($id)->count() != 0) {
            $user = Auth::user();
            $validation = UserFile::whereId($id)->first();

            $company_info = $user->company_info;
            if (!empty($company_info->logo)) {
                $path_logo = url('storage/uploads/photos/company_logo/' . $company_info->logo);
            } else {
                $path_logo = url('storage/uploads/photos/profile-placeholder.png');
            }

            $data = [
                'title' => trans('app.edit_account_validation'),
                'company' => $company_info->company,
                'name' => $user->name,
                'path_avatar' => $path_logo,
                'is_employer' => $user->is_employer(),
                'is_user' => $user->is_user(),
                'validation_number' => $company_info->validation_number,
                'validation' => $validation
            ];

            if ($company_info->status_validation === 3) {
                \LogActivity::store(trans('app.edit_account_validation'));
                return View::make('user.validations.edit', $data)->with(compact('user'));
            } else {
                return redirect()->route('validation');
            }
        } else {
            return redirect()->route('validation');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id, true);
        $user = Auth::user();
        $company_info = $user->company_info;
        $validation = UserFile::whereId($id)->first();

        $image_whitelist  = array('jpg', 'jpeg', 'png');
        $file_whitelist  = array('pdf');

        $rules = [
            'validation_number' => 'required',
        ];

        $this->validate($request, $rules);

        $data_company_info = [
            'validation_number' => $request->validation_number,
            'status_validation' => 1, //* Pending
        ];
        
        $company_info = CompanyInfo::where('user_id', $user->company_info->user_id)->update($data_company_info);

        if ($company_info) {
            $uuid = Uuid::uuid4()->toString();
            if ($request->hasFile('file_upload')) {
                $file = $request->file('file_upload');
                $ext = $file->getClientOriginalExtension();
                $file_name = $uuid;

                switch ($ext) {
                    case in_array(strtolower($ext), $image_whitelist):
                        $resized_image = Image::make($file)->resize(null, 256, function ($constraint) {
                            $constraint->aspectRatio();
                        })->stream();

                        $file_path = 'uploads/files/' . $file_name;

                        Storage::disk('public')->put($file_path, $resized_image->__toString());
                        $data_user_file = [
                            'filename' => $file_name,
                            'filename_origin' => $file->getClientOriginalName(),
                            'code' => 'company_verify_file'
                        ];
                        Storage::disk('public')->delete('uploads/files/'.$validation->filename);

                        $user_file = $validation->update($data_user_file);
                        
                        if (!$user_file) {
                            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
                        }
                        break;
                    case in_array(strtolower($ext), $file_whitelist):
                        $file_path = 'uploads/files/' . $file_name;

                        Storage::disk('public')->put($file_path, 'Contents');
                        $data_user_file = [
                            'filename' => $file_name,
                            'filename_origin' => $file->getClientOriginalName(),
                            'code' => 'company_verify_file'
                        ];
                        Storage::disk('public')->delete('uploads/files/'.$validation->filename);
                        
                        $user_file = $validation->update($data_user_file);

                        if (!$user_file) {
                            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
                        }

                        break;
                }
            }
            
            \LogActivity::store(trans('app.edit_account_validation'));
            return redirect()->route('validation')->with('success', __('app.validation_posted_success'));
        } else {
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
