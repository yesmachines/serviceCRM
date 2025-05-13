<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait OneSignalTrait {

    public function registerOUser($osSid, $deviceType) {
        auth('sanctum')->user()->device_type = $deviceType;
        auth('sanctum')->user()->os_sid = $osSid;
        auth('sanctum')->user()->save();
        \App\Models\UserOdevice::updateOrCreate(
                ['user_id' => auth('sanctum')->user()->id, 'os_sid' => $osSid]
        );
        return 1;
    }

    function sendONotification($body) {
        try {
            //Save to db
            foreach ($body['include_external_user_ids'] as $k => $userId) {
                $notification = new \App\Models\ServPushNotification();
                $notification->user_id = $userId;
                $notification->title = $body['headings']['en'];
                $notification->message = $body['contents']['en'];
                $notification->module = $body['data']['module'];
                $notification->module_id = $body['data']['module_id'];
                $notification->extras = $body['data'];
                $notification->save();
                $body['include_external_user_ids'][$k] = (string) $userId;
            }
            // return ['status' => true, 'message' => 'Push notification sent successfully!'];

            $http = new Client(['verify' => false]);
            $body['app_id'] = config('services.onesignal.app_id');
            $response = $http->post('https://onesignal.com/api/v1/notifications', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' .config('services.onesignal.app_key'),
                ],
                'json' => $body,
            ]);

            if ($response->getStatusCode() === 200) {
                return ['status' => true, 'message' => 'Push notification sent successfully!'];
            } else {
                return ['status' => false, 'message' => 'Failed to send push notification: ' . $response->getBody()];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Failed to send push notification: ' . $e->getMessage()];
        }
    }
}
