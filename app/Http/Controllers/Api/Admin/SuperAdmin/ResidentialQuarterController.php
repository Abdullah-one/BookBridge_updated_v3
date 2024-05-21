<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Http\Controllers\Controller;
use App\RepositoryPattern\ResidentialQuarterRepository;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

class ResidentialQuarterController extends Controller
{
    protected ResidentialQuarterRepository $residentialQuarterRepository;

    function __construct(ResidentialQuarterRepository $residentialQuarterRepository)
    {
        $this->residentialQuarterRepository = $residentialQuarterRepository;
    }

    public function getByCity(Request $request): JsonResponse
    {
        $city_id=$request->city_id;
        return response()->json($this->residentialQuarterRepository->getByCity($city_id));
    }
    public function customGet(Request $request): JsonResponse
    {
        $district=$request->district;
        $city_id=$request->city_id;
        return response()->json($this->residentialQuarterRepository->customGet($district,$city_id));
    }

    public function store(Request $request): void
    {
        $name=$request->name;
        $city_id=$request->city_id;
        $this->residentialQuarterRepository->store($name,$city_id);
    }

    public function update($id,Request $request): void
    {
        $name=$request->name;
        $city_id=$request->city_id;
        $result=$this->residentialQuarterRepository->update($id,$name,$city_id);
        if(!$result){
            abort(404);
        }
    }

    public function getByName(Request $request): JsonResponse
    {
        $name=$request->name;
        return response()->json($this->residentialQuarterRepository->getByName($name));
    }

    public function getRemovableResidentialQuarters(): JsonResponse
    {
        return \response()->json($this->residentialQuarterRepository->getRemovableResidentialQuarters());
    }

    public function destroyRemovableResidentialQuarter($id): void
    {

        $result = $this->residentialQuarterRepository->destroy($id);
        if (!$result) {
            abort(404);
        }
    }




}
