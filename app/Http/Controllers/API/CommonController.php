<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CommonController extends Controller {

    public function __construct() {
        $this->middleware('api');
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return successResponse('Success');
    }
    
    public function updateDevice(Request $request) {
        $validator = Validator::make($request->all(), [
                    'os_sid' => 'required',
                    'device_type' => 'required|in:android,ios',
        ]);

        if ($validator->fails()) {
            $allMessage = $validator->messages();
            $errorMessage = $validator->errors()->first();
            return errorResponse($errorMessage, $allMessage);
        }

        $request->user()->update([
            'device_type' => $request->device_type,
            'os_sid' => $request->os_sid,
        ]);

        \App\Models\UserOdevice::updateOrCreate(
                ['user_id' => $request->user()->id, 'os_sid' => $request->os_sid]
        );
        return successResponse('Success');
    }
}
