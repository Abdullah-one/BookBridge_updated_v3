<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\RepositoryPattern\PerformanceRepository;
use Illuminate\Support\Carbon;

class PerformanceController extends Controller
{
    protected PerformanceRepository $performanceRepository;
    function __construct(PerformanceRepository $performanceRepository)
    {
        $this->performanceRepository=$performanceRepository;
    }

    public function incrementStatus($exchangePoint_id,$status)
    {
        $currentDate = Carbon::now(); //var
        $year = $currentDate->year; //var
        $month = $currentDate->month; //var
        $performance=$this->performanceRepository->getByYearAndMonth($exchangePoint_id,$year,$month); //var
        if ($performance){
            $performance->increment($status); //database
        }
        else{
            $performance=$this->performanceRepository->create($exchangePoint_id,$month,$year);
            $performance->increment($status); //database
        }
        return $performance;
    }

    public function decrementStatus($exchangePoint_id,$status,$dateOfTransaction)
    {
        $carbonDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $dateOfTransaction);
        $year = $carbonDateTime->year; //var
        $month = $carbonDateTime->month; //var
        $performance=$this->performanceRepository->getByYearAndMonth($exchangePoint_id,$year,$month); //var
        $performance->decrement($status); //database

        return $performance;
    }

}
