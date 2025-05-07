<?php

function isActiveUrl(&$item) {
    $active = false;
    if (!$active && isset($item['active'])) {
        foreach ($item['active'] as $seg) {
            if (request()->is($seg)) {
                $active = true;
            }
        }
    }
    return $active;
}

function isAllowedUser(&$item, &$user) {
    $permission = true;
    if (isset($item['can'])) {
        if ($user->can($item['can'])) {
            $permission = true;
        } else {
            $permission = false;
        }
    }
    return $permission;
}

function cdn($asset) {
    //Check if we added cdn's to the config file
    if (!env('CDN_ENABLED', false)) {
        return Storage::disk('public')->url($asset);
    } else {
        return Storage::disk('s3')->url(env('CDN_FILE_DIR', 'dev/test/') . $asset);
    }
}

function successResponse($status, $data = null) {
    if (!empty($data)) {
        return response()->json([
                    "statusCode" => 10000,
                    "message" => $status,
                    "data" => $data,
                        ], 200);
    } else {
        return response()->json([
                    "statusCode" => 10000,
                    "message" => $status
                        ], 200);
    }
}

function errorResponse($status, $errorMessage = null, $eCode = 400) {
    return response()->json([
                "statusCode" => 20000,
                "message" => $status,
                "errorMessage" => $errorMessage
                    ], $eCode);
}

function systemResponse($status) {
    return response()->json([
                "statusCode" => 500,
                "message" => $status
                    ], 500);
    //return response()->json(['error' => $status, 401]);
}

function emailVerifyResponse($status, $data = null) {
    return response()->json([
                "statusCode" => 30000,
                "message" => $status,
                "data" => $data
                    ], 200);
}

function tokenResponse($status) {
    return response()->json([
                "statusCode" => 40000,
                "message" => $status
                    ], 401);
}
