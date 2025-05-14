<?php

namespace App\Http\Controllers\API\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('api');
    }

    public function profile(Request $request) {
        $user = auth('coordinator')->user();
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
