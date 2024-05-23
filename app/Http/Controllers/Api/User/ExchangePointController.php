<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ExchangePoint;
use App\Models\ResidentialQuarter;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use PharIo\Version\Exception;
use function Laravel\Prompts\select;

class ExchangePointController extends Controller
{
    public function getExchangePoints(): JsonResponse
    {
        $data=DB::table('accounts')->crossJoin('exchange_points',function (JoinClause $join) {
            $join->on('accounts.id', '=', 'exchange_points.account_id');


        })->select(['accounts.userName as point name','exchange_points.id'])->get();
        return response()->json($data);
    }

    public function getExchangePointsByStreetID(\Illuminate\Http\Request $request): JsonResponse
    {
        try{
            $residentialQuarter_id=$request->residentialQuarter_id ;
            $exchangePoint= DB::table('exchange_points')->where([
                'residentialQuarter_id'=>$residentialQuarter_id
            ])
                ->join('accounts','account_id','=','accounts.id')
                ->select([
                    'exchange_points.id',
                    'accounts.userName'
                ])
                ->get();

            return response()->json(['status'=>'success','data'=>$exchangePoint]);
        }
        catch(Exception $exception){
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }


    }
}
