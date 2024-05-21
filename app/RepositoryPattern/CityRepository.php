<?php

namespace App\RepositoryPattern;

use App\Models\Account;
use App\Models\Admin;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CityRepository
{
    public function getByDistrict(string $district): Collection
    {
        return DB::table('cities')->select(
            [
                'id',
                'name',
            ])
            ->where('district',$district)
            ->get();
    }

    public function getAdministratorCities($admin_id)
    {
        return Admin::find($admin_id)->cities()
        ->select([
            'cities.id',
            'district',
            'name',
            DB::raw('Date(cities.created_at) as date')
        ])
        ->orderby('cities.created_at')
        ->get();
    }

    public function checkExistingOfAttaching(Admin $admin,int $city_id):bool
    {
        return $admin->cities()->wherePivot('city_id', $city_id)->exists();
    }

    public function attachCity(int $admin_id,int $city_id): bool
    {
        $admin=Admin::find($admin_id);
        if($this->checkExistingOfAttaching($admin,$city_id))
        {
            return false;
        }
        $admin->cities()->attach($city_id);
        return true;
    }

    public function detachCity(int $admin_id,int $city_id): void
    {
        Admin::find($admin_id)->cities()->detach($city_id);
    }

    public function store( $name,  $district): void
    {
        City::create([
            'name' => $name,
            'district' => $district
        ]);
    }

    public function update( $id, $name,  $district): bool
    {
        $city=City::find($id);
        if($city) {
            $city->update([
                'name' => $name,
                'district' => $district
            ]);
            return true;
        }
        return false;
    }

    public function get($id)
    {

        return City::where('id',$id)
        ->select([
            'id',
            'name',
            'district',
            DB::raw('Date(cities.created_at) as date')
        ])
        ->first();
    }

    public function customGet( $district, $name)
    {
        return City::when($district, function (Builder $query) use ($name, $district) {
                $query->where('district',$district);
                    /*->when($name, function (Builder $query) use ($name) {
                        $query->where('name',$name);
                    });*/
            })
            ->select([
                'id',
                'name',
                'district',
                DB::raw('Date(cities.created_at) as date')
            ])
            ->get();
    }

    public function destroy($id): bool
    {
        $city=City::find($id);
        if($city){
            $city->delete();
            return true;
        }
        return false;
    }

    public function getRemovableCities()
    {
        return City::doesnthave('residentialQuarters')
            ->select([
                'id',
                'name',
                'district',
                DB::raw('Date(cities.created_at) as date')
            ])
            ->get();
    }

    public function IsRemovable($id):bool
    {
        if(City::has('residentialQuarters')){
            return false;
        }
        return true;
    }

    public function getAdminsOfCity($id)
    {
        return Account::whereHas('admin.cities',function (Builder $query) use ($id) {
            $query->where('cities.id',$id);
        })->get();

    }

    public function getByName($name)
    {
        return City::when($name,function (Builder $query) use ($name) {
            $query->where('name',$name);
        })
            ->select([
                'id',
                'name',
                'district',
                DB::raw('Date(cities.created_at) as date')
            ])
            ->first();

    }
}
/*
->where('cities.id',$id)->get();
$cities=collect();
foreach ($accounts as $account) {
$userComments = $account->without()

    // Merge comments into the collection
$comments = $comments->merge($userComments);
}
*/
