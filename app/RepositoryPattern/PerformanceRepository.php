<?php

namespace App\RepositoryPattern;

use App\Models\Performance;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PerformanceRepository
{
    public function getByYearAndMonth(int $exchangePoint_id,int $year, int $month)
    {
        return Performance::where([
            'exchangePoint_id' => $exchangePoint_id,
            'year' => $year,
            'month' => $month
        ])
            ->first();
    }


    public function create(int $exchangePoint_id, int $month, int $year)
    {
        return Performance::create([
            'exchangePoint_id' => $exchangePoint_id,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function updateByExchangePoint(int $exchangePoint_id, int $month, int $year, $data): bool
    {
        $performance=Performance::where([
            'exchangePoint_id' => $exchangePoint_id,
            'month' => $month,
            'year' => $year
        ])->first();
        if($performance){
            $performance->update($data);
            return true;
        }
        return false;
    }

    public function getPerformanceForSuperAdmin($year,$month,
        int $exchangePoint_id, int $residentialQuarter_id, int $district, int $city_Id, string $orderBy): Collection
    {
         return DB::table('performances')
             ->when($year,function (Builder $query) use ($year) {
                 $query->where('year',$year);
             })
            ->when($month,function (Builder $query) use ($month) {
                $query->where('month',$month);
            })
            ->when($exchangePoint_id,function (Builder $query) use ($exchangePoint_id) {
                $query->where('exchangePoint_id',$exchangePoint_id);
                    })
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','exchange_points.account_id','=','accounts.id')
            ->when($residentialQuarter_id,function (Builder $query) use ($residentialQuarter_id) {
                $query->where('exchange_points.residentialQuarter_id',$residentialQuarter_id);
            })
            ->join('residential_quarters','exchange_points.residentialQuarter_id','=','residential_quarters.id')
            ->when($city_Id,function (Builder $query) use ($city_Id) {
                $query->where('residential_quarters.city_id',$city_Id);
            })
            ->when($district,function (Builder $query) use ($district) {
                $query->join('cities',function (JoinClause $join) use ($district) {
                    $join->on('residential_quarters.city_id','=','cities.id')
                        ->where('cities.district',$district);
                });
            })
            ->select([
                'accounts.userName',
                'residential_quarters.name',
                'cities.name',
                'cities.district',
                DB::raw('SUM(performances.no_addedDonation) as performances.no_addedDonation'),
                DB::raw('SUM(performances.no_bookedDonation) as performances.no_bookedDonation'),
                DB::raw('SUM(performances.no_canceledDonationFromDonor) as performances.no_canceledDonationFromDonor'),
                DB::raw('SUM(performances.no_canceledDonationFromBeneficiary) as performances.no_canceledDonationFromBeneficiary'),
                DB::raw('SUM(performances.no_receivedDonation) as performances.no_receivedDonation'),
                DB::raw('SUM(performances.no_removedDonationByAdmin) as performances.no_removedDonationByAdmin'),
                DB::raw('SUM(performances.no_removedDonation) as performances.no_removedDonation'),
                DB::raw('SUM(performances.no_rejectedDonation) as performances.no_rejectedDonation'),
                DB::raw('SUM(performances.no_deliveredDonation) as performances.no_deliveredDonation'),
                DB::raw('SUM(performances.no_rejectedDonationFromBeneficiary) as performances.no_rejectedDonationFromBeneficiary'),
                DB::raw('SUM(performances.no_reachingMaxPackages) as performances.no_reachingMaxPackages'),
            ])
            ->groupBy('accounts.userName')
             ->orderBy($orderBy)
            ->get();

    }

    public function getPerformanceForAdmin($year,$month,
                                           int $exchangePoint_id, int $residentialQuarter_id, int $district, int $city_Id, string $orderBy): Collection
    {
        return DB::table('performances')
            ->when($year,function (Builder $query) use ($year) {
                $query->where('year',$year);
            })
            ->when($month,function (Builder $query) use ($month) {
                $query->where('month',$month);
            })
            ->when($exchangePoint_id,function (Builder $query) use ($exchangePoint_id) {
                $query->where('exchangePoint_id',$exchangePoint_id);
            })
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','exchange_points.account_id','=','accounts.id')
            ->when($residentialQuarter_id,function (Builder $query) use ($residentialQuarter_id) {
                $query->where('exchange_points.residentialQuarter_id',$residentialQuarter_id);
            })
            ->join('residential_quarters','exchange_points.residentialQuarter_id','=','residential_quarters.id')
            ->when($city_Id,function (Builder $query) use ($city_Id) {
                $query->where('residential_quarters.city_id',$city_Id);
            })
            ->when($district,function (Builder $query) use ($district) {
                $query->join('cities',function (JoinClause $join) use ($district) {
                    $join->on('residential_quarters.city_id','=','cities.id')
                        ->where('cities.district',$district);
                });
            })
            ->select([
                'accounts.userName',
                DB::raw('SUM(performances.no_addedDonation) as performances.no_addedDonation'),
                DB::raw('SUM(performances.no_bookedDonation) as performances.no_bookedDonation'),
                DB::raw('SUM(performances.no_canceledDonationFromDonor) as performances.no_canceledDonationFromDonor'),
                DB::raw('SUM(performances.no_canceledDonationFromBeneficiary) as performances.no_canceledDonationFromBeneficiary'),
                DB::raw('SUM(performances.no_receivedDonation) as performances.no_receivedDonation'),
                DB::raw('SUM(performances.no_removedDonationByAdmin) as performances.no_removedDonationByAdmin'),
                DB::raw('SUM(performances.no_removedDonation) as performances.no_removedDonation'),
                DB::raw('SUM(performances.no_rejectedDonation) as performances.no_rejectedDonation'),
                DB::raw('SUM(performances.no_deliveredDonation) as performances.no_deliveredDonation'),
                DB::raw('SUM(performances.no_rejectedDonationFromBeneficiary) as performances.no_rejectedDonationFromBeneficiary'),
                DB::raw('SUM(performances.no_reachingMaxPackages) as performances.no_reachingMaxPackages'),
            ])
            ->groupBy('accounts.userName')
            ->orderBy($orderBy)
            ->get();

    }

}
