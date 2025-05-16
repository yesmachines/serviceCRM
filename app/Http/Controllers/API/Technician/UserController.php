<?php

namespace App\Http\Controllers\API\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('api');
    }

    public function login(Request $request) {
        $rules = [
            'mobile' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }

        $user = User::select('users.*')->join('employees', 'employees.user_id', 'users.id')
                ->where('employees.phone', $request->mobile)
                ->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return errorResponse('These credentials do not match our records');
        }

        if ($user->hasAnyRole('servicemanager', 'servicecoordinator', 'servicetechnician', 'dcm')) {
            //To delete all token means to logout form other logged in devices
            //$user->tokens()->delete();
            $user->access_token = $user->createToken('auth_token', $user->getRoleNames()->toArray())->plainTextToken;
            return successResponse('Success', $this->userData($user));
        }
        return errorResponse(trans('These credentials do not match our records'));
    }

    public function profile(Request $request) {
        $user = auth('technician')->user();
        return successResponse('Success', $this->userData($user));
    }

    public function userData(&$user) {
        $user->with('employee');
        if ($user->hasAnyRole(['servicemanager', 'servicecoordinator'])) {
            $user->prefix = '/api/coordinator/';
        } else {
            $user->prefix = '/api/';
        }
        unset($user->roles);
        $user->employee->image_url = !empty($user->employee->image_url) ? Storage::disk('public')->url($user->employee->image_url) : null;
        return $user;
    }

}
