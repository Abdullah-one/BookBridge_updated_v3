<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ExchangePointController extends Controller
{
    public function getExchangePoints(): JsonResponse
    {
        $data=DB::table('accounts')->crossJoin('exchange_points',function (JoinClause $join) {
            $join->on('accounts.id', '=', 'exchange_points.account_id');


        })->select(['accounts.userName as point name','exchange_points.id'])->get();
        return response()->json($data);
    }
}
