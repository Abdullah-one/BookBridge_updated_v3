<?php

namespace App\Http\Controllers\Api\Point;

use App\Http\Controllers\Controller;
use App\RepositoryPattern\PerformanceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PerformanceController extends Controller
{
    protected PerformanceRepository $performanceRepository;

    function __construct(PerformanceRepository $performanceRepository)
    {
        $this->performanceRepository=$performanceRepository;
    }

    public function getPerformanceForAdmin(Request $request): JsonResponse
    {
        Gate::authorize('admin');
        $city_Id=$request->city_id;
        $district_id=$request->district;
        $residentialQuarter_id=$request->residentialQuarter_id;
        $exchangePoint_id=$request->exchangePoint_id;
        $month=$request->month;
        $year=$request->year;
        $orderBy=$request->orderBy;
        return response()->json($this->performanceRepository->getPerformanceForSuperAdmin($year,$month,$exchangePoint_id,
            $residentialQuarter_id,$district_id,$city_Id,$orderBy));


    }
}
