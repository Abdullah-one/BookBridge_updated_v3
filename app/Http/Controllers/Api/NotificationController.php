<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PharIo\Version\Exception;

class NotificationController extends Controller
{
    public function sendPushNotification($data): bool
    {
        //TODO:
        $credentialsFilePath = "firebase/fcm.json";
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        //TODO:
        $apiurl = 'https://fcm.googleapis.com/v1/projects/<PROJECT_ID>/messages:send';
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];
//            $test_data = [
//                "title" => "TITLE_HERE",
//                "description" => "DESCRIPTION_HERE",
//            ];
//
//            $data['data'] = $test_data;
//
//            $data['token'] = $user['fcm_token']; // Retrive fcm_token from users table

        $payload['message'] = $data;
        $payload = json_encode($payload);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_exec($ch);
        $res = curl_close($ch);
        if ($res) {
            return true;
        }
        else{
            return false;
        }
    }

    public function create($data): bool
    {
        Notification::create($data['data']);
        unset($data['data']['account_id']);
        if($this->sendPushNotification($data)){
            return true;
        }
        return false;
    }

    public function get(): JsonResponse
    {
        try {
            if (Gate::denies('isUser')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $account_id=auth()->user()->id;
            $result = DB::table('notifications')
                ->where('account_id',$account_id)
                ->select([
                    'title',
                    'message',
                    'created_at',
                    'isRead'
                ])
                ->paginate();
            Notification::update([
                'isRead'=>true
            ]);
            return response()->json(['status' => 'success', 'data' => $result]);
        }
        catch (Exception $e){
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ بالخادم']);
        }

    }

    public function updateFcmToken(Request $request): JsonResponse
    {

        try {
            if (Gate::denies('isUser')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $fcmToken=$request->fcmToken;
            DB::table('accounts')->where('id',auth()->user()->id)
                ->first()
                ->update([
                    'fcm_token'=>$fcmToken
                ]);
            return \response()->json(['status'=>'success']);
        }
        catch (\Exception $exception){
            return \response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }
    }


}
