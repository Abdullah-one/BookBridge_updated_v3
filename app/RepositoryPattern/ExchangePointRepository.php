<?php

namespace App\RepositoryPattern;

use App\Models\Account;
use App\Models\ExchangePoint;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExchangePointRepository
{

    public function getByResidentialQuarter($residentialQuarter_id): Collection
    {
        return DB::table('exchange_points')
            ->join('accounts','account_id','=','accounts.id')
            ->select(
            [
                'exchange_points.id',
                'userName',
            ])
            ->where('residentialQuarter_id',$residentialQuarter_id)
            ->get();
    }

    public function customGet($residentialQuarter_id,$district,$city_id)
    {
        if($residentialQuarter_id) {
            $result = ExchangePoint::where('residentialQuarter_id', $residentialQuarter_id);
        }
        else {
            $result = ExchangePoint::whereHas('residentialQuarter.cities', function ($query) use ( $district, $city_id) {
                if($city_id){
                    $query->where('city_id', $city_id);
                }

                elseif ($district) {
                    $query->where('cities.district', $district);
                }

            });
        }

        $result = $result->select([
                'id',
                'maxPackages',
                'no_packages',
                'locationDescription',
                'location',
                'account_id',
                'residentialQuarter_id',
                DB::raw('Date(created_at) as date')

            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    "userName" => $item->account? $item->account->userName: null,
                    "phoneNumber" => $item->account? $item->account->phoneNumber: null,
                    "email" => $item->account? $item->account->email: null,
                    'maxPackages' => $item->maxPackages,
                    'no_packages' => $item->no_packages,
                    'locationDescription' => $item->locationDescription,
                    'location' => $item->location,
                    'residentialQuarter' => $item->residentialQuarter? $item->residentialQuarter->name : null,
                    'district' => $item->residentialQuarter->city ? $item->residentialQuarter->city->district : null,
                    'city' => $item->residentialQuarter->city ? $item->residentialQuarter->city->name : null,
                    "date" => $item->date
                ];
            });



        return $result;
    }

    public function store(int $account_id,int $residentialQuarter_id,int $maxPackages,$locationDescription, string $location): void
    {
        ExchangePoint::create([
            'account_id' => $account_id,
            'residentialQuarter_id' => $residentialQuarter_id,
            'maxPackages' => $maxPackages,
            'locationDescription' => $locationDescription,
            'location' => $location

        ]);
    }

    public function update(int $id,int $residentialQuarter_id,int $maxPackages,$locationDescription, string $location): bool
    {

        $exchangePoint=ExchangePoint::find($id);
        if($exchangePoint) {
            $exchangePoint->update([
                'residentialQuarter_id' => $residentialQuarter_id,
                'maxPackages' => $maxPackages,
                'locationDescription' => $locationDescription,
                'location' => $location
            ]);
            return true;
        }
        return false;
    }

    public function get(int $id)
    {
        return ExchangePoint::where('account_id',$id)
            ->select([
                'id',
                'maxPackages',
                'no_packages',
                'locationDescription',
                'location',
                'account_id',
                'residentialQuarter_id',
                DB::raw('Date(created_at) as date')

            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    "userName" => $item->account? $item->account->userName: null,
                    "phoneNumber" => $item->account? $item->account->phoneNumber: null,
                    "email" => $item->account? $item->account->email: null,
                    'maxPackages' => $item->maxPackages,
                    'no_packages' => $item->no_packages,
                    'locationDescription' => $item->locationDescription,
                    'location' => $item->location,
                    'residentialQuarter' => $item->residentialQuarter? $item->residentialQuarter->name : null,
                    'district' => $item->residentialQuarter->city ? $item->residentialQuarter->city->district : null,
                    'city' => $item->residentialQuarter->city ? $item->residentialQuarter->city->name : null,
                    "date" => $item->date
                ];
            });

    }

    public function softDelete($id)
    {
    }

}
