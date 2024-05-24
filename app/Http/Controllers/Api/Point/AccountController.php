<?php

namespace App\Http\Controllers\Api\Point;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AccountController extends Controller
{
    public function getPointInformation(): JsonResponse
    {
        try {
            if (Gate::denies('isPoint')) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $account_id = auth()->user()->id;
            $result=DB::table('accounts')->where('accounts.id', $account_id)
                ->join('exchange_points', 'accounts.id', '=', 'exchange_points.account_id')
                ->select([
                    'phoneNumber',
                    'role',
                    'userName',
                    'email',
                    'maxPackages',
                    'no_packages',
                    'location',
                ])->first();
            return response()->json(['status'=>'success','data'=>$result]);
        }
        catch (\Exception $exception){
            return response()->json(['status' => 'fail', 'message' => 'هناك خطأ بالخادم']);
        }
    }
}
