<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Files;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidationController extends Controller
{
    public function index()
    {
        $title = trans('app.account_validation');
        $current_user = Auth::user();

        // if ($user->is_admin() || $user->is_sysadmin()) {
        //     $validation = User::whereUserType('employer')->orderBy('name', 'asc')->orderBy('status_validation', 'asc');
        // } elseif ($user->is_employer()) {
        //     $validation = User::where('id', '=', $current_user->id)->orderBy('name', 'asc');
        // }

        return view('admin.validation', compact('title', 'validation'));
    }

    public function addValidation()
    {
        $title = trans('app.account_validation');
        return view('admin.add_validation', compact('title'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'nib'               => 'required_if:npwp,""|nullable',
            'npwp'              => 'required_if:nib,""|regex:/(^[0-9][0-9][.]([\d]{3})[.]([\d]{3})[.][\d][-]([\d]{3})[.]([\d]{3})+$)+/|nullable',
            'file_attachment'   => 'file|mimes:jpeg,png,jpg,pdf'
        ];
        $this->validate($request, $rules);
        $data = [
            'nib'               => $request->nib,
            'npwp'              => $request->npwp,
            'status_validation' => 1,
        ];
        $user_update = User::where('id', $user->id)->update($data);

        //Upload File
        $files = $request->file('file_attachment');
        if ($request->hasFile('file_attachment')) {
            foreach ($files as $file) {
                // $file->store('users/' . $this->user->id . '/messages');
                $nama_file = time() . "_" . $file->getClientOriginalName();
            }
            try {
                Storage::disk('public')->putFileAs('uploads/user/validations/', $files, $nama_file);
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->input())->with('error', $e->getMessage());
            }
        }

        if ($user_update) {
            return redirect(route('dashboard'))->with('success', trans('app.post_has_been_created'));
        }

        return redirect()->back()->with('error', trans('app.error_msg'));
    }

    public function validationEdit()
    {
        $title = trans('app.account_validation');
        $validation = Auth::user();
        // $files = Files::where('user_id', '=', $user->id)->where('notes', '=', 'nib/npwp')->orderBy('name', 'asc');

        return view('admin.validation_edit', compact('title', 'validation'));
    }

    public function validationEditPost($id = null, Request $request)
    {

        $user = Auth::user();

        if ($id) {
            $validation = User::find($id);
            $files = Files::where('user_id', '=', $id)->where('notes', '=', 'nib')->orWhere('notes', '=', 'npwp')->orderBy('name', 'asc');
        }

        //Validating
        $rules = [
            'nib'  => 'empty_if:npwp|nib',
            'npwp' => 'empty_if:nib|npwp'
        ];
        $this->validate($request, $rules);

        return view('admin.validation_edit', compact('title', 'validation', 'files'));
    }

    // public function uploadFeatureFile($request){

    //     $fileName = null;
    //     if ($request->hasFile('feature_file')){

    //         $file = $request->file('feature_file');

    //         $valid_extensions = ['jpg','jpeg','png'];
    //         if ( ! in_array(strtolower($file->getClientOriginalExtension()), $valid_extensions) ){
    //             return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension') ;
    //         }
    //         $file_base_name = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());

    //         $fileName = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $file->getClientOriginalExtension();

    //         try{
    //             Storage::disk('public')->putFileAs('uploads/user/validations/', $file, $fileName);
    //         } catch (\Exception $e){
    //             return redirect()->back()->withInput($request->input())->with('error', $e->getMessage()) ;
    //         }
    //     }

    //     return $fileName;
    // }
}
