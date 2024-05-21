<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ResidentialQuarter;
use App\RepositoryPattern\ResidentialQuarterRepository;
use Illuminate\Http\JsonResponse;

class ResidentialQuarterController extends Controller
{
    protected ResidentialQuarterRepository $residentialQuarterRepository;

    function __construct(ResidentialQuarterRepository $residentialQuarterRepository)
    {
        $this->residentialQuarterRepository = $residentialQuarterRepository;
    }
    public function getByCity($city_id): JsonResponse
    {
        return response()->json($this->residentialQuarterRepository->getByCity($city_id));
    }

    public function getResidentialQuarterAndItsPoints(): JsonResponse
    {
        $residentialQuarters= ResidentialQuarter::with(['exchangePoints'=> function ($query) {
            $query->with(['account'=>function ($query) {
                $query->select([
                    'id',
                    'userName',
                ]);
            }])
            ->select([
                'id',
                'account_id',
                'residentialQuarter_id'
            ]);

        }])
            ->select([
                'id',
                'name',

            ])
            ->get();
        return response()->json($residentialQuarters);

    }
}
