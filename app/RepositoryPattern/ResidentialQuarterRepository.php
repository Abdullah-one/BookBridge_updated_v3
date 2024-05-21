<?php

namespace App\RepositoryPattern;

use App\Models\City;
use App\Models\ResidentialQuarter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class ResidentialQuarterRepository
{
    public function getByCity($city_id)
    {
        return DB::table('residential_quarters')->where('city_id',$city_id)
            ->select([
                'id',
                'name'
            ])
            ->get();
    }

    public function customGet($district,$city_id)
    {
        $result= ResidentialQuarter::whereHas('city',function ($query) use ($city_id, $district) {
            $query->when($district,function (Builder $query) use ($city_id, $district) {
                $query->where('cities.district',$district)
                    ->when($city_id, function (Builder $query) use ($city_id) {
                        $query->where('city_id',$city_id);
                    });
            });
        })
            ->select([
                'id',
                'name',
                'city_id',
                DB::raw('Date(created_at) as date')

            ])
            ->get();

        $result = $result->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'district' => $item->city ? $item->city->district : null,
                'city' => $item->city ? $item->city->name : null,
                "date" => $item->date
            ];
        });

        return $result;
    }

    public function store( $name,  $city_id):void
    {
        ResidentialQuarter::create([
            'name' => $name,
            'city_id' => $city_id
        ]);
    }

    public function getByName($name)
    {
        $result= ResidentialQuarter::when($name,function (Builder $query) use ($name) {
            $query->where('name','like',$name.'%');
        })
            ->with('city')
            ->select([
                'id',
                'name',
                'city_id',
                DB::raw('Date(created_at) as date')
            ])
            ->get();

        $result = $result->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'district' => $item->city ? $item->city->district : null,
                'city' => $item->city ? $item->city->name : null,
                "date" => $item->date
            ];
        });

        return $result;

    }

    public function update( $id, $name,  $city_id): bool
    {

        $residentialQuarter=ResidentialQuarter::find($id);
        if($residentialQuarter) {
            $residentialQuarter->update([
                'name' => $name,
                'city_id' => $city_id
            ]);
            return true;
        }
        return false;
    }

    public function destroy($id): bool
    {
        $residentialQuarter=ResidentialQuarter::find($id);
        if($residentialQuarter){
            $residentialQuarter->delete();
            return true;
        }
        return false;
    }

    public function getRemovableResidentialQuarters()
    {
        $result= ResidentialQuarter::doesnthave('exchangePoints')->with('city')
            ->select([
                'id',
                'name',
                'city_id',
                DB::raw('Date(created_at) as date')
            ])
            ->get();
        $result = $result->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'district' => $item->city ? $item->city->district : null,
                'city' => $item->city ? $item->city->name : null,
                "date" => $item->date
            ];
        });

        return $result;
    }

}
