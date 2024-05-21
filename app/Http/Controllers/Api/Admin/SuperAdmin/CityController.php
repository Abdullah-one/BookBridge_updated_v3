<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\Account;
use App\RepositoryPattern\CityRepository;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    protected CityRepository $cityRepository;

    function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getByDistrict(Request $request): JsonResponse
    {
        $district=$request->district;
        return response()->json($this->cityRepository->getByDistrict($district));
    }

    public function getAdministratorCities($admin_id): JsonResponse
    {
        //Gate::authorize('IsSuperAdmin');
        return response()->json($this->cityRepository->getAdministratorCities($admin_id));
    }

    public function store(Request $request)
    {
        $name=$request->name;
        $district=$request->district;
        $this->cityRepository->store($name,$district);
    }

    public function update($id,Request $request): void
    {
        $name=$request->name;
        $district=$request->district;
        $result=$this->cityRepository->update($id,$name,$district);
        if(!$result){
            abort(404);
        }
    }

    public function get($id)
    {
        return response()->json($this->cityRepository->get($id));
    }

    public function getByName(Request $request)
    {
        $name=$request->name;
        return response()->json($this->cityRepository->getByName($name));
    }

    public function customGet(Request $request): JsonResponse
    {
        $name=$request->name;
        $district=$request->district;
        return response()->json($this->cityRepository->customGet($district, $name));
    }

    public function getRemovableCities(): JsonResponse
    {
        return \response()->json($this->cityRepository->getRemovableCities());
    }

    public function getAdminsOfCity($id)
    {
        return \response()->json($this->cityRepository->getAdminsOfCity($id));

    }

    public function destroyRemovableCity($id): void
    {

        $result = $this->cityRepository->destroy($id);
        if (!$result) {
            abort(404);
        }
    }



    public function addCityForAdministration($admin_id,$city_id): void
    {
        //Gate::authorize('IsSuperAdmin');
        $isAttach=$this->cityRepository->attachCity($admin_id,$city_id);
        if(! $isAttach){
            abort(409);
        }
    }

    public function removeCityFromAdministration($admin_id,$city_id): void
    {
        //Gate::authorize('IsSuperAdmin');
        $this->cityRepository->detachCity($admin_id,$city_id);
    }


}
